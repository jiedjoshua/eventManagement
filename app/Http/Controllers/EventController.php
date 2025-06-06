<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Event;



class EventController extends Controller
{
    public function create()
    {
        // Logic to show the booking form
        return view('user.book');
    }

 public function store(Request $request)
{
    Log::info('Form submitted with data:', $request->all());

    try {
        $event = new Event();
        $event->event_name = $request->event_name;
        $event->event_type = $request->event_type;
        $event->package_type = $request->package_type;
        $event->event_date = $request->event_date;
        $event->start_time = $request->start_time;
        $event->end_time = $request->end_time;
        $event->venue_name = $request->venue_name;
        $event->event_duration = $request->event_duration;
        $event->guest_count = $request->guest_count;
        $event->enable_rsvp = $request->has('enable_rsvp');
        $event->rsvp_deadline = $request->rsvp_deadline;
        $event->allow_plus_one = $request->has('allow_plus_one');
        $event->reminder_schedule = $request->reminder_schedule;

        if ($request->hasFile('guest_list')) {
            $file = $request->file('guest_list');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('guest_lists', $filename, 'public');
            $event->guest_list_path = $filename;
        }

        $event->user_id = Auth::id();  // <--- Add this line

        $event->save();

        Log::info('Event saved successfully. Redirecting...');

        $user = Auth::user();

        switch ($user->role) {
            case 'super_admin':
                return redirect()->route('superadmin.dashboard')->with('success', 'Event created!');
            case 'event_manager':
                return redirect()->route('eventmanager.dashboard')->with('success', 'Event created!');
            case 'admin':
                return redirect()->route('admin.dashboard')->with('success', 'Event created!');
            default:
                return redirect()->route('user.dashboard')->with('success', 'Event created!');
        }
    } catch (\Exception $e) {
        Log::error('Error saving event: ' . $e->getMessage());
        return back()->with('error', 'Something went wrong.');
    }
}

public function showDashboard(Event $event)
{
    $totalInvited = $event->users()->count();
   // $totalAccepted = $event->users()->wherePivot('rsvp_status', 'accepted')->count();
  //  $totalDeclined = $event->users()->wherePivot('rsvp_status', 'declined')->count();
   // $checkedInCount = $event->users()->wherePivot('checked_in', true)->count(); // If you track check-in
   // $notCheckedIn = $totalAccepted - $checkedInCount;

    return view('manager.manage-events.view.eventDashboard', [
        'event' => $event,
        'total_invited' => $totalInvited,
      //  'total_accepted' => $totalAccepted,
       // 'total_declined' => $totalDeclined,
      //  'checked_in_count' => $checkedInCount,
      //  'not_checked_in' => $notCheckedIn,
    ]);
}

  
}
