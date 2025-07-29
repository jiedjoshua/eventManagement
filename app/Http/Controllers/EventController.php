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
        $churches = \App\Models\Venue::where('type', 'church')->where('is_active', true)->get();

        return view('booking-form', compact('packages', 'addons', 'churches'));
    }

    public function store(Request $request)
    {
        Log::info('Booking form submitted:', $request->all());
        Log::info('Church and reception IDs received:', [
            'church_id' => $request->church_id,
            'reception_id' => $request->reception_id,
            'venue_id' => $request->venue_id,
            'event_type' => $request->eventType
        ]);

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
                'church_id' => 'nullable|exists:venues,id',
                'reception_id' => 'nullable|exists:venues,id',
            ]);

            // Additional validation for wedding/baptism events
            if ($request->eventType === 'wedding' || $request->eventType === 'baptism') {
                if (!$request->church_id && !$request->reception_id) {
                    throw new \Exception('For wedding and baptism events, you must select both a church and reception venue.');
                }
            }

            // Check venue availability based on event type
            $eventType = $request->eventType;
            $venue = Venue::findOrFail($request->venueId);
            
            if ($eventType === 'wedding' || $eventType === 'baptism') {
                // For wedding/baptism, check both church and reception availability
                $church = null;
                $reception = null;
                
                if ($request->has('church_id') && $request->church_id) {
                    $church = Venue::findOrFail($request->church_id);
                    if (!$church->isAvailable($request->eventDate, $request->startTime, $request->endTime)) {
                        throw new \Exception('Selected church is not available for the chosen date and time.');
                    }
                }
                
                if ($request->has('reception_id') && $request->reception_id) {
                    $reception = Venue::findOrFail($request->reception_id);
                    if (!$reception->isAvailable($request->eventDate, $request->startTime, $request->endTime)) {
                        throw new \Exception('Selected reception venue is not available for the chosen date and time.');
                    }
                }
                
                // Check capacity (use the larger capacity between church and reception)
                $maxCapacity = max($church ? $church->capacity : 0, $reception ? $reception->capacity : 0);
                if ($request->guestCount > $maxCapacity) {
                    throw new \Exception('Guest count exceeds venue capacity.');
                }
            } else {
                // For other event types, check single venue availability
                if (!$venue->isAvailable($request->eventDate, $request->startTime, $request->endTime)) {
                    throw new \Exception('Selected venue is not available for the chosen date and time.');
                }
                
                // Check venue capacity
                if ($request->guestCount > $venue->capacity) {
                    throw new \Exception('Guest count exceeds venue capacity.');
                }
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

            // Set church and reception IDs for wedding/baptism
            if ($eventType === 'wedding' || $eventType === 'baptism') {
                $booking->church_id = $request->church_id;
                $booking->reception_id = $request->reception_id;
                
                Log::info('Church and reception IDs set:', [
                    'church_id' => $request->church_id,
                    'reception_id' => $request->reception_id
                ]);
            }

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

            // Calculate venue costs
            $venueCost = 0;
            if ($eventType === 'wedding' || $eventType === 'baptism') {
                if ($request->has('church_id') && $request->church_id) {
                    $church = Venue::find($request->church_id);
                    if ($church) {
                        $churchPrice = $this->extractPriceFromRange($church->price_range);
                        $venueCost += $churchPrice;
                        Log::info('Church venue cost added:', ['church_id' => $request->church_id, 'church_price' => $churchPrice]);
                    } else {
                        Log::warning('Church not found:', ['church_id' => $request->church_id]);
                    }
                }
                if ($request->has('reception_id') && $request->reception_id) {
                    $reception = Venue::find($request->reception_id);
                    if ($reception) {
                        $receptionPrice = $this->extractPriceFromRange($reception->price_range);
                        $venueCost += $receptionPrice;
                        Log::info('Reception venue cost added:', ['reception_id' => $request->reception_id, 'reception_price' => $receptionPrice]);
                    } else {
                        Log::warning('Reception not found:', ['reception_id' => $request->reception_id]);
                    }
                }
            } else {
                $venueCost = $this->extractPriceFromRange($venue->price_range);
            }

            // Calculate total price (package + addons + venue costs)
            $booking->total_price = $booking->package_price_at_booking + $booking->addons_price_at_booking + $venueCost;

            Log::info('Price calculation:', [
                'package_price' => $booking->package_price_at_booking,
                'addons_price' => $booking->addons_price_at_booking,
                'venue_cost' => $venueCost,
                'total_price' => $booking->total_price,
                'event_type' => $eventType
            ]);

            // Validate that total price is greater than 0
            if ($booking->total_price <= 0) {
                throw new \Exception('Total price must be greater than 0. Please check package, addon, and venue prices.');
            }

            // Set initial status
            $booking->status = 'pending';

            // Save the booking
            $booking->save();

            Log::info('Booking saved successfully:', [
                'booking_id' => $booking->id,
                'reference' => $booking->reference,
                'church_id' => $booking->church_id,
                'reception_id' => $booking->reception_id,
                'total_price' => $booking->total_price
            ]);

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
        
        // Count registered users who checked in
        $registeredCheckedIn = $event->users()->wherePivot('checked_in_at', '!=', null)->count();
        
        // Count external guests who checked in
        $externalCheckedIn = \App\Models\ExternalGuest::where('event_id', $event->id)
            ->whereNotNull('checked_in_at')
            ->count();
        
        // Total checked in (registered + external)
        $checkedInCount = $registeredCheckedIn + $externalCheckedIn;
        
        $notCheckedIn = $totalAccepted - $registeredCheckedIn;

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

        // URL decode the data first, then JSON decode
        $dataJson = urldecode($dataJson);
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

            $user = DB::table('users')
                ->select('id', 'first_name', 'last_name', 'email')
                ->where('id', $userId)
                ->first();

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
        // Get the event and load only guests who have checked in
        $event = Event::findOrFail($eventId);
        
        // Get checked-in registered guests
        $checkedInGuests = $event->guests()
            ->wherePivotNotNull('checked_in_at')
            ->withPivot('rsvp_status', 'plus_one', 'checked_in_at')
            ->get();
        
        // Get checked-in external guests directly
        $checkedInExternalGuests = \App\Models\ExternalGuest::where('event_id', $eventId)
            ->whereNotNull('checked_in_at')
            ->get();
        
        // Replace the guests relationship with only checked-in guests
        $event->setRelation('guests', $checkedInGuests);
        
        // Set the external guests relationship
        $event->setRelation('checkedInExternalGuests', $checkedInExternalGuests);

        // Debug: Let's check what we're getting
        \Log::info('Event ID: ' . $eventId);
        \Log::info('Checked in external guests count: ' . $checkedInExternalGuests->count());
        \Log::info('External guests data: ' . $checkedInExternalGuests->toJson());

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
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"])
                    ->orWhereRaw("CONCAT(last_name, ' ', first_name) LIKE ?", ["%{$search}%"]);
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

    public function getAllGuests(Request $request, Event $event)
    {
        $page = $request->query('page', 1);
        $perPage = $request->query('per_page', 20); // Default 20 guests per page

        $guests = $event->guests()
            ->withPivot('checked_in_at')
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->paginate($perPage)
            ->through(function ($guest) {
                return [
                    'id' => $guest->id,
                    'first_name' => $guest->first_name,
                    'last_name' => $guest->last_name,
                    'email' => $guest->email,
                    'checked_in_at' => $guest->pivot->checked_in_at
                ];
            });

        return response()->json([
            'guests' => $guests->items(),
            'pagination' => [
                'current_page' => $guests->currentPage(),
                'last_page' => $guests->lastPage(),
                'per_page' => $guests->perPage(),
                'total' => $guests->total(),
                'next_page_url' => $guests->nextPageUrl(),
                'prev_page_url' => $guests->previousPageUrl(),
            ]
        ]);
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

    /**
     * Get real-time guests data for the guest list page
     */
    public function getGuestsData(Event $event)
    {
        $guests = $event->guests()
            ->select('users.id', 'first_name', 'last_name', 'email')
            ->withPivot('rsvp_status', 'plus_one', 'checked_in_at')
            ->get()
            ->map(function ($guest) {
                return [
                    'id' => $guest->id,
                    'first_name' => $guest->first_name,
                    'last_name' => $guest->last_name,
                    'email' => $guest->email,
                    'rsvp_status' => $guest->pivot->rsvp_status,
                    'checked_in_at' => $guest->pivot->checked_in_at,
                    'initials' => strtoupper(substr($guest->first_name, 0, 1) . substr($guest->last_name, 0, 1))
                ];
            });

        return response()->json([
            'guests' => $guests,
            'total_count' => $guests->count(),
            'last_updated' => now()->toISOString()
        ]);
    }

    /**
     * Get real-time checked-in data for the checked-in page
     */
    public function getCheckedInData(Event $event)
    {
        // Get checked-in registered guests
        $checkedInGuests = $event->guests()
            ->wherePivotNotNull('checked_in_at')
            ->select('users.id', 'first_name', 'last_name', 'email')
            ->withPivot('rsvp_status', 'plus_one', 'checked_in_at')
            ->get()
            ->map(function ($guest) {
                return [
                    'id' => $guest->id,
                    'first_name' => $guest->first_name,
                    'last_name' => $guest->last_name,
                    'email' => $guest->email,
                    'checked_in_at' => $guest->pivot->checked_in_at,
                    'formatted_checkin_time' => \Carbon\Carbon::parse($guest->pivot->checked_in_at)->format('F d, Y g:i A'),
                    'initials' => strtoupper(substr($guest->first_name, 0, 1) . substr($guest->last_name, 0, 1)),
                    'type' => 'registered'
                ];
            });

        // Get checked-in external guests
        $checkedInExternalGuests = \App\Models\ExternalGuest::where('event_id', $event->id)
            ->whereNotNull('checked_in_at')
            ->get()
            ->map(function ($guest) {
                return [
                    'id' => $guest->id,
                    'name' => $guest->name ?? 'External Guest',
                    'unique_code' => $guest->unique_code ?? 'N/A',
                    'checked_in_at' => $guest->checked_in_at,
                    'formatted_checkin_time' => \Carbon\Carbon::parse($guest->checked_in_at)->format('F d, Y g:i A'),
                    'initials' => strtoupper(substr($guest->name ?? 'E', 0, 1)),
                    'type' => 'external'
                ];
            });

        return response()->json([
            'registered_guests' => $checkedInGuests,
            'external_guests' => $checkedInExternalGuests,
            'summary' => [
                'registered_count' => $checkedInGuests->count(),
                'external_count' => $checkedInExternalGuests->count(),
                'total_count' => $checkedInGuests->count() + $checkedInExternalGuests->count()
            ],
            'last_updated' => now()->toISOString()
        ]);
    }

    /**
     * Extract numeric price from price range string
     * Handles formats like "₱1,000 - ₱5,000" or "₱1,000" or "1000"
     */
    private function extractPriceFromRange($priceRange)
    {
        if (empty($priceRange)) {
            return 0;
        }

        // Remove peso symbol and spaces
        $cleanPrice = str_replace(['₱', ' ', ','], '', $priceRange);
        
        // If it's a range (contains "-"), take the first number
        if (strpos($cleanPrice, '-') !== false) {
            $parts = explode('-', $cleanPrice);
            $firstPart = trim($parts[0]);
            // Extract first number from the string
            if (preg_match('/\d+/', $firstPart, $matches)) {
                return (float) $matches[0];
            }
        } else {
            // Single price, extract the number
            if (preg_match('/\d+/', $cleanPrice, $matches)) {
                return (float) $matches[0];
            }
        }
        
        return 0; // Default fallback
    }
}
