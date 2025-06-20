<?php
#test 
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

        return view('user.dashboard', compact('participationData', 'eventTypesData', 'stats'));
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
        $bookedEvents = Booking::with(['venue', 'package'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.book', compact('bookedEvents'));
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


}
