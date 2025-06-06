<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class InviteController extends Controller
{
   public function show($eventId)
{
    if (!Auth::check()) {
        return redirect()->guest(route('login', ['redirect' => url()->current()]));
    }

    $event = Event::findOrFail($eventId);
    $userId = Auth::id();

    // Check if user already accepted
    $pivot = $event->users()->where('user_id', $userId)->first();

    if ($pivot && $pivot->pivot->rsvp_status === 'accepted') {
        // Generate QR code
        $qrData = json_encode([
            'event_id' => $event->id,
            'user_id' => $userId,
            'timestamp' => now()->toIso8601String(),
        ]);

        $qrCode = QrCode::size(132)->generate($qrData);

        // Show invite page with QR code directly
        return view('invite', compact('event', 'qrCode'));
    }

    // Otherwise, show RSVP confirmation page (accept/decline)
    return view('invite-confirm', compact('event'));
}


 public function accept($eventId)
{
    if (!Auth::check()) {
        return redirect()->guest(route('login', ['redirect' => url()->current()]));
    }

    $event = Event::findOrFail($eventId);
    $userId = Auth::id();
    
    // Get RSVP status if exists
    $pivot = $event->users()->where('user_id', $userId)->first();

    if ($pivot && $pivot->pivot->rsvp_status === 'accepted') {
       
    } else if ($pivot) {
        
        $event->users()->updateExistingPivot($userId, [
            'rsvp_status' => 'accepted',
            'updated_at' => now()
        ]);
    } else {
        $event->users()->attach($userId, [
            'rsvp_status' => 'accepted',
            'plus_one' => false,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    // Generate QR code
    $qrData = json_encode([
        'event_id' => $event->id,
        'user_id' => $userId,
        'timestamp' => now()->toIso8601String(),
    ]);

    $qrCode = QrCode::size(300)->generate($qrData);

    return view('invite', compact('event', 'qrCode'));
}


   public function decline($eventId)
{
    if (!Auth::check()) {
        return redirect()->guest(route('login', ['redirect' => url()->current()]));
    }

    $event = Event::findOrFail($eventId);
    $userId = Auth::id();

    // Update RSVP to declined
    $event->users()->updateExistingPivot($userId, [
        'rsvp_status' => 'declined',
        'updated_at' => now()
    ]);

    return view('invite-declined', compact('event'));
}

}



// composer require simplesoftwareio/simple-qrcode
