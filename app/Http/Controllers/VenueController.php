<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Import Log facade

class VenueController extends Controller
{
    public function index(Request $request)
    {
        Log::info('Venue request received', ['type' => $request->type]); // Add logging

        $type = $request->query('type');
        $query = Venue::with(['spaces', 'gallery'])->where('is_active', true);
        
        if ($type && $type !== 'both') {
            $query->where('type', $type);
        }

        $venues = $query->get();

        Log::info('Venues found', ['count' => $venues->count()]); // Add logging

        return response()->json([
            'success' => true,
            'data' => $venues
        ]);
    }

    public function show(Venue $venue)
    {
        $venue->load(['spaces', 'gallery']);
        
        return response()->json([
            'success' => true,
            'data' => $venue
        ]);
    }
}