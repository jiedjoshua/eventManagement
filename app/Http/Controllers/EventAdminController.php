<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::query();
        // Add search/filter logic here if needed
        $events = $query->orderBy('created_at', 'desc')->paginate(15);
        $addons = \App\Models\Addon::where('is_active', true)->orderBy('sort_order')->get();
        $venues = \App\Models\Venue::orderBy('name')->get();
        $packages = \App\Models\Package::where('is_active', true)->orderBy('name')->get();
        return view('admin.eventManagement.list-events', compact('events', 'addons', 'venues', 'packages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'date' => 'required|date',
            // Add other fields as needed
        ]);
        $event = Event::create($validated);
        return response()->json(['success' => true, 'message' => 'Event created successfully!', 'event' => $event]);
    }

    public function edit(Event $event)
    {
        return response()->json(['success' => true, 'event' => $event]);
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'date' => 'required|date',
            // Add other fields as needed
        ]);
        $event->update($validated);
        return response()->json(['success' => true, 'message' => 'Event updated successfully!', 'event' => $event]);
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return response()->json(['success' => true, 'message' => 'Event deleted successfully!']);
    }
} 