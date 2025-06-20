<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use App\Models\Booking;
use Carbon\Carbon;


class EventManagerController extends Controller
{
    public function index()
    {
        // 1. Total Events Managed (all events)
        $totalEvents = Event::count();

        // 2. Upcoming Events (all future events)
        $upcomingEvents = Event::where('event_date', '>=', Carbon::today())->count();

        // 3. Pending Bookings/Approvals (all bookings with status 'pending')
        $pendingBookings = Booking::where('status', 'pending')->count();

        // 4. Cancelled Events (all events with status 'cancelled')
        $cancelledEvents = Event::where('status', 'cancelled')->count();

        // Chart 1: Events Per Month (current year)
        $eventsPerMonth = Event::whereYear('event_date', now()->year)
            ->selectRaw('EXTRACT(MONTH FROM event_date) as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Prepare data for all 12 months
        $months = [];
        $eventCounts = [];
        for ($i = 1; $i <= 12; $i++) {
            $months[] = date('M', mktime(0, 0, 0, $i, 1));
            $eventCounts[] = $eventsPerMonth[$i] ?? 0;
        }

        // Chart 2: Event Types Distribution
        $eventTypes = Event::selectRaw('event_type, COUNT(*) as count')
            ->groupBy('event_type')
            ->pluck('count', 'event_type')
            ->toArray();

        return view('manager.dashboard', [
            'totalEvents' => $totalEvents,
            'upcomingEvents' => $upcomingEvents,
            'pendingBookings' => $pendingBookings,
            'cancelledEvents' => $cancelledEvents,
            'months' => $months,
            'eventCounts' => $eventCounts,
            'eventTypeLabels' => array_keys($eventTypes),
            'eventTypeCounts' => array_values($eventTypes),
        ]);
    }

    public function showEvent()
    {
        $events = Event::all();  // Assuming your event model is Event
        return view('manager.manage-events.events', compact('events')) /*, compact('event') */;
    }

    // BOOKING //
    public function showBooked()
    {
        $bookings = Booking::orderBy('created_at', 'desc')->get();
        return view('manager.manage-events.booked-events', compact('bookings'));
    }

    public function approve(Booking $booking)
    {
        // Update booking status
        $booking->update([
            'status' => 'approved',
            'approved_at' => now(),
            'amount_due' => $booking->total_price, 
            'amount_paid' => 0,
            'payment_status' => 'pending',
        ]);

        // Create new event from booking
        $startTime = Carbon::parse($booking->start_time);
        $endTime = Carbon::parse($booking->end_time);
        $duration = $startTime->diff($endTime);

        $durationString = $duration->h . 'h ' . $duration->i . 'm';
        Event::create([
            'user_id' => $booking->user_id,
            'booking_id' => $booking->id,
            'event_name' => $booking->event_name,
            'event_type' => $booking->event_type,
            'event_date' => $booking->event_date,
            'start_time' => $booking->start_time,
            'end_time' => $booking->end_time,
            'venue_name' => $booking->venue->name,
            'guest_count' => $booking->guest_count,
            'total_price' => $booking->total_price,
            'package_type' => $booking->package->name,
            'event_duration' => $durationString,
            'status' => 'upcoming'
        ]);

        //  Send notification/email to user with payment link

        return redirect()->back()->with('success', 'Booking approved and event created successfully');
    }

    public function reject(Request $request, Booking $booking)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500'
        ]);

        $booking->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
            'rejected_at' => now()
        ]);

        return redirect()->back()->with('success', 'Booking rejected successfully');
    }

    public function getDetails(Booking $booking)
    {
        $booking->load(['venue', 'package']);

        // Add formatted date and time
        $booking->formatted_date = date('F d, Y', strtotime($booking->event_date));
        $booking->formatted_time = date('h:i A', strtotime($booking->start_time)) . ' - ' .
            date('h:i A', strtotime($booking->end_time));

        return response()->json([
            'booking' => $booking
        ]);
    }

    public function upcomingEvents(Request $request)
    {
        $query = Event::with('booking')
            ->where('status', 'upcoming')
            ->where('event_date', '>=', now());

        // Apply event type filter
        if ($request->has('event_type') && $request->event_type != '') {
            $query->where('event_type', $request->event_type);
        }

        // Apply sorting
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'date-asc':
                    $query->orderBy('event_date', 'asc')
                        ->orderBy('start_time', 'asc');
                    break;
                case 'date-desc':
                    $query->orderBy('event_date', 'desc')
                        ->orderBy('start_time', 'desc');
                    break;
                case 'name-asc':
                    $query->orderBy('event_name', 'asc');
                    break;
                case 'name-desc':
                    $query->orderBy('event_name', 'desc');
                    break;
                default:
                    $query->orderBy('event_date', 'asc');
            }
        } else {
            // Default sorting
            $query->orderBy('event_date', 'asc');
        }

        $events = $query->paginate(9)->withQueryString();

        return view('manager.manage-events.upcoming-events', compact('events'));
    }

    public function reschedule(Request $request, Event $event)
    {
        $request->validate([
            'event_date' => 'required|date|after:today',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
        ]);

        // Calculate new duration
        $startTime = Carbon::parse($request->start_time);
        $endTime = Carbon::parse($request->end_time);
        $duration = $startTime->diff($endTime);
        $durationString = $duration->h . 'h ' . $duration->i . 'm';

        $event->update([
            'event_date' => $request->event_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'event_duration' => $durationString
        ]);

        return redirect()->back()->with('success', 'Event rescheduled successfully');
    }
    public function details(Event $event)
    {

        $event->load(['booking', 'user']);

        return response()->json([
            'event' => [
                'id' => $event->id,
                'event_date' => $event->event_date,
                'start_time' => substr($event->start_time, 0, 5),
                'end_time' => substr($event->end_time, 0, 5),
                'event_name' => $event->event_name,
                'event_type' => $event->event_type,
                'venue_name' => $event->venue_name,
                'guest_count' => $event->guest_count,
                'package_type' => $event->package_type,
                'status' => $event->status,
                'booking' => [
                    'reference' => $event->booking->reference ?? 'N/A'
                ],
                'contact_person' => [
                    'name' => $event->user->first_name . ' ' . $event->user->last_name,
                    'email' => $event->user->email,
                    'phone' => $event->user->phone_number
                ]
            ]
        ]);
    }

    public function showGuestLists()
    {

        $events = Event::with('guests')->orderBy('event_date', 'desc')->get();

        return view('manager.guest-list', compact('events'));
    }

    public function guests(Event $event)
    {
        $guests = $event->guests()->paginate(10); // 10 per page
        return response()->json([
            'guests' => $guests->items(),
            'pagination' => [
                'current_page' => $guests->currentPage(),
                'last_page' => $guests->lastPage(),
                'next_page_url' => $guests->nextPageUrl(),
                'prev_page_url' => $guests->previousPageUrl(),
            ]
        ]);
    }

    public function showGenerateExternalQRCodes()
    {
        // Get all events (or filter as needed)
        $events = Event::orderBy('event_date')->get();

        return view('manager.generate-qr', compact('events'));
    }
}
