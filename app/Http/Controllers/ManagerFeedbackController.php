<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\Event;

class ManagerFeedbackController extends Controller
{
    public function analytics(Request $request)
    {
        // Example: Get feedback stats grouped by event
        $feedbacks = Feedback::with('event')
            ->selectRaw('event_id, AVG(rating) as avg_rating, COUNT(*) as feedback_count')
            ->groupBy('event_id')
            ->get();

        $events = Event::whereIn('id', $feedbacks->pluck('event_id'))->get()->keyBy('id');

        return view('manager.feedback-analytics', [
            'feedbacks' => $feedbacks,
            'events' => $events,
        ]);
    }

    public function eventFeedbacks(Event $event)
    {
        $feedbacks = $event->feedbacks()->with('user')->latest()->get();
        return view('manager.event-feedbacks', [
            'event' => $event,
            'feedbacks' => $feedbacks,
        ]);
    }

    public function eventSummary(Request $request)
    {
        $events = \App\Models\Event::whereHas('feedbacks')
            ->withCount(['users as confirmed_bookings' => function($q) {
                $q->where('rsvp_status', 'confirmed');
            }])
            ->with(['feedbacks'])
            ->get()
            ->map(function($event) {
                $event->avg_rating = $event->feedbacks->avg('rating');
                return $event;
            });
        return view('manager.event-summary', [
            'events' => $events,
        ]);
    }
} 