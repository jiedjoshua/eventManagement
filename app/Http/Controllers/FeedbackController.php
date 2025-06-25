<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function create($eventId)
    {
        $event = Event::findOrFail($eventId);
        return view('user.feedback', compact('event'));
    }

    public function store(Request $request, $eventId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'nullable|string|max:255',
            'comments' => 'nullable|string|max:2000',
        ]);

        Feedback::create([
            'event_id' => $eventId,
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'title' => $request->title,
            'comments' => $request->comments,
        ]);

        return redirect()->route('user.bookedEvents')->with('success', 'Thank you for your feedback!');
    }
}
