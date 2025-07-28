<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\Booking;
use App\Models\Venue;
use App\Models\Package;
use Carbon\Carbon;

class UserController extends Controller
{

    public function index()
    {
        if (Auth::user()->role !== 'regular_user') {
            abort(403, 'Unauthorized');
        }

        $user = Auth::user();

        // Get user's bookings (for charts and confirmed bookings count)
        $bookings = Booking::where('user_id', $user->id)->get();

        // Get user's invited events (for upcoming events count)
        $invitedEvents = $user->invitedEvents()->get();

        // Chart 1: Event Participation Over Time (Last 12 months)
        $participationData = $this->getParticipationData($bookings);

        // Chart 2: Event Types Breakdown
        $eventTypesData = $this->getEventTypesData($bookings);

        // Dashboard stats
        $stats = $this->getDashboardStats($user, $bookings, $invitedEvents);

        return view('user.dashboard', compact('participationData', 'eventTypesData', 'stats', 'bookings'));
    }

    private function getParticipationData($bookings)
    {
        $months = [];
        $data = [];

        // Generate last 12 months
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months[] = $date->format('M');

            // Count bookings for this month
            $count = $bookings->filter(function ($booking) use ($date) {
                return $booking->created_at->format('Y-m') === $date->format('Y-m');
            })->count();

            $data[] = $count;
        }

        return [
            'labels' => $months,
            'data' => $data
        ];
    }

    private function getEventTypesData($bookings)
    {
        $eventTypes = $bookings->groupBy('event_type')
            ->map(function ($group) {
                return $group->count();
            })
            ->toArray();

        // If no data, provide default structure
        if (empty($eventTypes)) {
            $eventTypes = [
                'Wedding' => 0,
                'Birthday' => 0,
                'Corporate' => 0,
                'Other' => 0
            ];
        }

        return [
            'labels' => array_keys($eventTypes),
            'data' => array_values($eventTypes)
        ];
    }

    private function getDashboardStats($user, $bookings, $invitedEvents)
    {
        // Confirmed bookings are those with 'approved' status
        $confirmedBookings = $bookings->where('status', 'approved')->count();

        // Upcoming events are the events the user is invited to (future events)
        $upcomingEvents = $invitedEvents->where('event_date', '>=', Carbon::today())->count();

        // Past events are bookings with past event dates
        $pastEvents = $bookings->where('event_date', '<', Carbon::today())->count();

        return [
            'upcoming_events' => $upcomingEvents,
            'confirmed_bookings' => $confirmedBookings,
            'past_events' => $pastEvents
        ];
    }


    public function bookedEvents()
    {
        $bookedEvents = Booking::with(['venue', 'package', 'event', 'payments'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.book', [
            'bookedEvents' => $bookedEvents,
            'activePage' => 'booked-events'
        ]);
    }

    public function editBooking($reference)
    {
        $booking = Booking::where('reference', $reference)->firstOrFail();
        $venues = Venue::all();
        $packages = Package::all();

        return view('user.edit-booking', compact('booking', 'venues', 'packages'));
    }

    public function updateBooking(Request $request, $reference)
    {
        $booking = Booking::where('reference', $reference)->firstOrFail();

        $validated = $request->validate([
            'event_type' => 'required|string',
            'event_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'guest_count' => 'required|integer|min:1',
            'venue_notes' => 'nullable|string',
            'additional_notes' => 'nullable|string',
        ]);

        $booking->update($validated);

        return redirect()->route('bookings.edit', $reference)
            ->with('success', 'Booking updated successfully');
    }

    public function attendingEvents()
    {
        $user = Auth::user();

        $acceptedEvents = $user->acceptedEvents()->get();

        return view('user.attending-events', compact('acceptedEvents'));
    }

    public function payments()
    {
        $user = Auth::user();
        $bookings = Booking::where('user_id', auth()->id())
            ->where('status', 'approved')
            ->whereIn('payment_status', ['pending', 'partial'])
            ->orderBy('event_date', 'asc')
            ->get();

        return view('user.payment.payments', compact('bookings'));
    }

    public function showAccountSettings()
    {
        $user = Auth::user();
        return view('user.account-settings', compact('user'));
    }

    public function showGuestList($reference)
    {
        // Find the booking by reference and ensure it belongs to the authenticated user
        $booking = Booking::where('reference', $reference)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Get the associated event
        $event = $booking->event;
        
        if (!$event) {
            return redirect()->back()->with('error', 'No event found for this booking.');
        }

        // Get only guests who accepted the RSVP
        $acceptedGuests = $event->guests()
            ->wherePivot('rsvp_status', 'accepted')
            ->select('users.id', 'first_name', 'last_name', 'email')
            ->withPivot('checked_in_at')
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();

        return view('user.guest-list', compact('booking', 'event', 'acceptedGuests'));
    }

    public function cancelBooking(Request $request, $reference)
    {
        try {
            // Simple test to see if the method is being called
            \Log::info('Cancel booking method called', [
                'reference' => $reference,
                'user_id' => Auth::id(),
                'authenticated' => Auth::check(),
                'request_method' => $request->method(),
                'has_csrf_token' => $request->has('_token'),
                'session_id' => session()->getId()
            ]);
            
            // Check if user is authenticated
            if (!Auth::check()) {
                \Log::warning('User not authenticated');
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated.'
                ], 401);
            }
            
            // Basic validation
            $request->validate([
                'cancellation_reason' => 'required|string|max:500'
            ]);
            
            // Find the booking
            $booking = Booking::where('reference', $reference)->first();
            
            \Log::info('Booking lookup result', [
                'booking_found' => $booking ? true : false,
                'booking_user_id' => $booking ? $booking->user_id : null,
                'auth_user_id' => Auth::id(),
                'booking_status' => $booking ? $booking->status : null,
                'reference_searched' => $reference
            ]);
            
            // Debug: Let's also check if there are any bookings at all for this user
            $userBookings = Booking::where('user_id', Auth::id())->get();
            \Log::info('User bookings count', [
                'total_user_bookings' => $userBookings->count(),
                'user_booking_references' => $userBookings->pluck('reference')->toArray()
            ]);
            
            if (!$booking) {
                return response()->json([
                    'success' => false,
                    'message' => 'Booking not found.'
                ], 404);
            }
            
            // Check authorization - Allow users to cancel their own bookings
            if ($booking->user_id !== Auth::id()) {
                \Log::warning('Authorization failed', [
                    'booking_user_id' => $booking->user_id,
                    'auth_user_id' => Auth::id(),
                    'booking_reference' => $reference,
                    'booking_status' => $booking->status
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'You can only cancel bookings that belong to your account. Please contact support if you believe this is an error.'
                ], 403);
            }
            
            // Check if booking can be cancelled
            if ($booking->status !== 'approved') {
                \Log::warning('Booking status check failed', [
                    'booking_status' => $booking->status,
                    'booking_reference' => $reference,
                    'auth_user_id' => Auth::id()
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Only approved bookings can be cancelled. Current status: ' . ucfirst($booking->status)
                ], 400);
            }
            
            // Calculate refund amount
            $refundAmount = 0;
            $refundDetails = [];
            
            $amountPaid = $booking->amount_paid ?? 0;
            
            // Calculate refund based on cancellation policy
            $daysUntilEvent = now()->diffInDays($booking->event_date, false);
            
            if ($daysUntilEvent > 30) {
                // Full refund if cancelled more than 30 days before event
                $refundAmount = $amountPaid;
                $refundDetails = [
                    'type' => 'full',
                    'percentage' => 100,
                    'reason' => 'Cancelled more than 30 days before event'
                ];
            } elseif ($daysUntilEvent > 14) {
                // 75% refund if cancelled 15-30 days before event
                $refundAmount = $amountPaid * 0.75;
                $refundDetails = [
                    'type' => 'partial',
                    'percentage' => 75,
                    'reason' => 'Cancelled 15-30 days before event'
                ];
            } elseif ($daysUntilEvent > 7) {
                // 50% refund if cancelled 8-14 days before event
                $refundAmount = $amountPaid * 0.50;
                $refundDetails = [
                    'type' => 'partial',
                    'percentage' => 50,
                    'reason' => 'Cancelled 8-14 days before event'
                ];
            } else {
                // No refund if cancelled within 7 days
                $refundAmount = 0;
                $refundDetails = [
                    'type' => 'none',
                    'percentage' => 0,
                    'reason' => 'Cancelled within 7 days of event'
                ];
            }
            
            // Round to 2 decimal places
            $refundAmount = round($refundAmount, 2);
            
            // Update booking with cancellation details
            $booking->update([
                'status' => 'cancelled',
                'cancellation_reason' => $request->cancellation_reason,
                'cancelled_at' => now()
            ]);
            
            // Create refund record if applicable
            if ($refundAmount > 0) {
                \App\Models\Payment::create([
                    'reference' => 'REFUND-' . strtoupper(\Illuminate\Support\Str::random(8)),
                    'booking_id' => $booking->id,
                    'user_id' => $booking->user_id,
                    'amount' => -$refundAmount, // Negative amount for refund
                    'paid_at' => now(),
                    'payment_type' => 'refund',
                    'refund_reason' => $request->cancellation_reason
                ]);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Booking cancelled successfully',
                'refund' => [
                    'amount' => $refundAmount,
                    'details' => $refundDetails,
                    'original_amount' => $amountPaid
                ]
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Booking cancellation error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
