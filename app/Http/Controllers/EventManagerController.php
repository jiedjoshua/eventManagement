<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventManagerController extends Controller
{
    public function index()
    {
        if (Auth::user()->role !== 'event_manager') {
            abort(403, 'Unauthorized');
        }

        // Fetch event manager specific data (e.g., events they manage)
        // $events = Event::where('manager_id', Auth::id())->get();

        return view('manager.dashboard' /*, compact('events') */);
    }
}
