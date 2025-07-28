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
            
            // Check authorization
            if ($booking->user_id !== Auth::id()) {
                \Log::warning('Authorization failed', [
                    'booking_user_id' => $booking->user_id,
                    'auth_user_id' => Auth::id()
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized.'
                ], 403);
            }
            
            // Check if booking can be cancelled
            if ($booking->status !== 'approved') {
                return response()->json([
                    'success' => false,
                    'message' => 'Only approved bookings can be cancelled.'
                ], 400);
            }
            
            // Simple update - just change status
            $booking->update([
                'status' => 'cancelled'
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Booking cancelled successfully',
                'refund' => [
                    'amount' => 0,
                    'details' => [
                        'type' => 'none',
                        'reason' => 'Test cancellation'
                    ],
                    'original_amount' => 0
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
