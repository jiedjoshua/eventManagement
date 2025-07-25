<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Event;
use App\Models\Package;
use App\Models\Addon;
use App\Models\Venue;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;
use App\Models\ExternalGuest;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use ZipArchive;



class EventController extends Controller
{
    public function create()
    {
        $packages = Package::with('features')->where('is_active', true)->get();
        $addons = Addon::where('is_active', true)->orderBy('sort_order')->get();

        return view('booking-form', compact('packages', 'addons'));
    }

    public function store(Request $request)
    {
        Log::info('Booking form submitted:', $request->all());

        try {
            DB::beginTransaction();

            // Validate request
            $request->validate([
                'eventName' => 'required|string|max:255',
                'eventType' => 'required|string',
                'eventDate' => 'required|date|after:today',
                'startTime' => 'required',
                'endTime' => 'required|after:startTime',
                'guestCount' => 'required|integer|min:1',
                'venueId' => 'required|exists:venues,id',
                'packageId' => 'required|exists:packages,id',
                'addons' => 'nullable|array',
                'addons.*' => 'exists:addons,id',
                'venueNotes' => 'nullable|string',
                'additionalNotes' => 'nullable|string',
            ]);

            // Check venue availability
            $venue = Venue::findOrFail($request->venueId);
            if (!$venue->isAvailable($request->eventDate, $request->startTime, $request->endTime)) {
                throw new \Exception('Selected venue is not available for the chosen date and time.');
            }

            // Check venue capacity
            if ($request->guestCount > $venue->capacity) {
                throw new \Exception('Guest count exceeds venue capacity.');
            }

            // Get package
            $package = Package::findOrFail($request->packageId);

            // Create booking
            $booking = new Booking();
            $booking->user_id = Auth::id();
            $booking->venue_id = $venue->id;
            $booking->package_id = $package->id;
            $booking->event_name = $request->eventName;
            $booking->event_type = $request->eventType;
            $booking->event_date = $request->eventDate;
            $booking->start_time = $request->startTime;
            $booking->end_time = $request->endTime;
            $booking->guest_count = $request->guestCount;
            $booking->venue_notes = $request->venueNotes;
            $booking->additional_notes = $request->additionalNotes;

            // Handle addons if selected
            if ($request->has('addons')) {
                $booking->selected_addons = $request->addons;
            }

            // Calculate and set prices
            $booking->package_price_at_booking = $package->base_price;

            // Calculate addons price if any addons selected
            if ($request->has('addons')) {
                $addonsPrice = Addon::whereIn('id', $request->addons)->sum('price');
                $booking->addons_price_at_booking = $addonsPrice;
            } else {
                $booking->addons_price_at_booking = 0;
            }

            // Calculate total price
            $booking->total_price = $booking->package_price_at_booking + $booking->addons_price_at_booking;

            // Validate that total price is greater than 0
            if ($booking->total_price <= 0) {
                throw new \Exception('Total price must be greater than 0. Please check package and addon prices.');
            }

            // Set initial status
            $booking->status = 'pending';

            // Save the booking
            $booking->save();

            DB::commit();

            // Return success response
            return response()->json([
                'success' => true,
                'message' => 'Your booking request has been submitted successfully!',
                'booking' => [
                    'id' => $booking->id,
                    'reference' => $booking->reference,
                    'status' => $booking->status
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Booking creation failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function traceBooking(Request $request)
    {
        $reference = $request->reference;

        $booking = Booking::with(['user', 'venue', 'package'])
            ->where('reference', $reference)
            ->first();

        if (!$booking) {
            return response()->json([
                'success' => false,
                'message' => 'Booking not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'booking' => [
                'reference' => $booking->reference,
                'status' => $booking->status,
                'event_name' => $booking->event_name,
                'event_date' => $booking->event_date,
                'venue' => $booking->venue->name,
                'package' => $booking->package->name,
                'total_price' => $booking->total_price,
                'created_at' => $booking->created_at->format('Y-m-d H:i:s'),
                'customer_name' => $booking->user->first_name,
            ]
        ]);
    }

    public function showBooking($reference)
    {
        $booking = Booking::with(['user', 'venue', 'package'])
            ->where('reference', $reference)
            ->firstOrFail();

        return view('bookings', compact('booking'));
    }



    public function showDashboard(Event $event)
    {
        $totalInvited = $event->users()->count();
        $totalAccepted = $event->users()->wherePivot('rsvp_status', 'accepted')->count();
        $totalDeclined = $event->users()->wherePivot('rsvp_status', 'declined')->count();
        $checkedInCount = $event->users()->wherePivot('checked_in_at', '!=', null)->count();   // If you track check-in
        $notCheckedIn = $totalAccepted - $checkedInCount;

        return view('manager.manage-events.view.eventDashboard', [
            'event' => $event,
            'total_invited' => $totalInvited,
            'total_accepted' => $totalAccepted,
            'total_declined' => $totalDeclined,
            'checked_in_count' => $checkedInCount,
            'not_checked_in' => $notCheckedIn,
        ]);
    }

    public function showQRScanner(Event $event)
    {
        // Logic to show the QR scanner for the event
        return view('manager.manage-events.view.qrscanner', compact('event'));
    }

    public function scanCheckIn(Request $request)
    {
        $dataJson = $request->query('data');

        if (!$dataJson) {
            return response()->json(['error' => 'No QR data found.'], 400);
        }

        $data = json_decode($dataJson, true);

        if (!$data) {
            return response()->json(['error' => 'Invalid QR data format.'], 400);
        }



        if (isset($data['event_id']) && isset($data['external_code'])) {
            $eventId = $data['event_id'];
            $externalCode = $data['external_code'];

            $externalGuest = ExternalGuest::where('event_id', $eventId)
                ->where('unique_code', $externalCode)
                ->first();

            if (!$externalGuest) {
                return response()->json([
                    'error' => 'Invalid or unregistered external guest QR code.',
                    'code' => 'EXTERNAL_GUEST_NOT_FOUND'
                ], 404);
            }

            // Prevent double check-in
            if ($externalGuest->checked_in_at) {
                $formattedDate = \Carbon\Carbon::parse($externalGuest->checked_in_at)
                    ->format('F d, Y g:ia');
                return response()->json([
                    'error' => 'This QR code has already been used for check-in.',
                    'code' => 'EXTERNAL_ALREADY_CHECKED_IN',
                    'checked_in_at' => $formattedDate
                ], 400);
            }

            // Mark as checked in (only if not already checked in)
            $externalGuest->checked_in_at = now();
            $externalGuest->save();

            return response()->json([
                'message' => 'Check-in successful (external guest)',
                'code' => 'EXTERNAL_CHECKIN_SUCCESS',
                'guest' => [
                    'name' => $externalGuest->name,
                    'checked_in_at' => $externalGuest->checked_in_at->format('F d, Y g:ia')
                ]
            ]);
        }

        // --- Registered User QR (existing logic) ---
        if (isset($data['event_id']) && isset($data['user_id'])) {
            $eventId = $data['event_id'];
            $userId = $data['user_id'];

            $event = Event::find($eventId);
            if (!$event) {
                return response()->json(['error' => 'Event not found.'], 404);
            }

            // Get the pivot data with the checked_in_at field
            $eventUser = DB::table('event_user')
                ->where('event_id', $eventId)
                ->where('user_id', $userId)
                ->first();

            if (!$eventUser) {
                return response()->json(['error' => 'User is not invited to this event.'], 403);
            }

            // Check if user has already checked in
            if ($eventUser->checked_in_at !== null) {
                $formattedDate = \Carbon\Carbon::parse($eventUser->checked_in_at)
                    ->format('F d, Y g:ia');

                return response()->json([
                    'error' => 'This QR code has already been used for check-in.',
                    'checked_in_at' => $formattedDate
                ], 400);
            }

            // If not checked in, proceed with check-in
            $now = now();
            DB::table('event_user')
                ->where('event_id', $eventId)
                ->where('user_id', $userId)
                ->update(['checked_in_at' => $now]);

            $user = DB::table('users')->where('id', $userId)->first();

            return response()->json([
                'message' => 'Check-in successful',
                'user' => $user,
                'checked_in_at' => $now->format('F d, Y g:ia')
            ]);
        }

        // --- Fallback: Invalid QR ---
        return response()->json(['error' => 'Invalid QR data.'], 400);
    }


    public function showGuestList($eventId)
    {
        // Eager load users with pivot data (rsvp_status, plus_one)
        $event = Event::with(['guests' => function ($query) {
            $query->select('users.id', 'first_name', 'last_name', 'email')
                ->withPivot('rsvp_status', 'plus_one');
        }])->findOrFail($eventId);


        return view('manager.manage-events.view.guest-list', compact('event'));
    }

    public function showCheckedInList($eventId)
    {
        // Eager load only guests who have checked in (checked_in_at is not null)
        $event = Event::with(['guests' => function ($query) {
            $query->select('users.id', 'first_name', 'last_name', 'email')
                ->withPivot('rsvp_status', 'plus_one', 'checked_in_at')
                ->wherePivotNotNull('checked_in_at');
        }])->findOrFail($eventId);

        return view('manager.manage-events.view.checkedIn', compact('event'));
    }


    public function showManualCheckin(Event $event)
    {
        return view('manager.manage-events.view.manualCheckin', compact('event'));
    }

    public function searchGuests(Request $request, Event $event)
    {
        $search = $request->query('search');

        $guests = $event->guests()
            ->where(function ($query) use ($search) {
                $query->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->withPivot('checked_in_at')  // Make sure this is included
            ->get()
            ->map(function ($guest) {
                return [
                    'id' => $guest->id,
                    'first_name' => $guest->first_name,
                    'last_name' => $guest->last_name,
                    'email' => $guest->email,
                    'checked_in_at' => $guest->pivot->checked_in_at  // Explicitly include the pivot data
                ];
            });

        return response()->json(['guests' => $guests]);
    }
    public function manualCheckIn(Request $request, Event $event, $guestId)
    {
        $guest = $event->guests()->where('user_id', $guestId)->first();

        if (!$guest) {
            return response()->json([
                'success' => false,
                'message' => 'Guest not found'
            ], 404);
        }

        if ($guest->pivot->checked_in_at) {
            return response()->json([
                'success' => false,
                'message' => 'Guest has already checked in'
            ], 400);
        }

        $event->guests()->updateExistingPivot($guestId, [
            'checked_in_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Guest checked in successfully'
        ]);
    }

    public function generateExternalQRCodes(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'quantity' => 'required|integer|min:1|max:500',
        ]);

        $event = Event::findOrFail($request->event_id);
        $quantity = $request->quantity;

        // Sanitize event name for filename
        $eventNameForFile = preg_replace('/[^A-Za-z0-9_\-]/', '_', $event->event_name);

        // Create a temporary directory
        $tempDir = storage_path('app/temp_external_qr_' . uniqid());
        mkdir($tempDir);

        for ($i = 1; $i <= $quantity; $i++) {
            $uniqueCode = Str::uuid()->toString();
            $externalGuest = ExternalGuest::create([
                'event_id' => $event->id,
                'unique_code' => $uniqueCode,
            ]);
            $qrData = json_encode([
                'event_id' => $event->id,
                'external_code' => $uniqueCode,
            ]);
            $qrImage = QrCode::format('png')->size(300)->margin(10)->generate($qrData);
            file_put_contents($tempDir . DIRECTORY_SEPARATOR . "external_guest_{$externalGuest->id}.png", $qrImage);
        }

        // Create ZIP with event name
        $zipFileName = $eventNameForFile . '_qr_codes_' . time() . '.zip';
        $zipPath = storage_path('app/' . $zipFileName);
        $zip = new ZipArchive;
        if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
            foreach (glob($tempDir . '/*.png') as $file) {
                $zip->addFile($file, basename($file));
            }
            $zip->close();
        }

        // Clean up temp files
        foreach (glob($tempDir . '/*.png') as $file) {
            unlink($file);
        }
        rmdir($tempDir);

        // Return ZIP as download, with event name as filename
        return response()->download($zipPath, $zipFileName)->deleteFileAfterSend(true);
    }
}
