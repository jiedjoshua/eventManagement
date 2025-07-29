<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use App\Models\VenueUnavailability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; 
use App\Models\VenueGallery;
use App\Models\VenueSpace;
use Illuminate\Support\Facades\Storage;

class VenueController extends Controller
{
    public function index(Request $request)
    {
        Log::info('Venue request received', ['type' => $request->type]);

        $type = $request->query('type');
        $query = Venue::with(['spaces', 'gallery'])->where('is_active', true);
        
        if ($type && $type !== 'both') {
            // Show venues that match the selected type OR venues with type 'both'
            $query->where(function($q) use ($type) {
                $q->where('type', $type)
                  ->orWhere('type', 'both');
            });
        }

        $venues = $query->get();

        Log::info('Venues found', ['count' => $venues->count()]);

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

    public function checkAvailability(Request $request)
    {
        Log::info('checkAvailability called', $request->all());
        
        $request->validate([
            'venue_id' => 'required|exists:venues,id',
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $venue = Venue::findOrFail($request->venue_id);
        $isAvailable = $venue->isAvailable($request->date, $request->start_time, $request->end_time);

        Log::info('Availability check result', [
            'venue_id' => $venue->id,
            'venue_name' => $venue->name,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'is_available' => $isAvailable
        ]);

        return response()->json([
            'success' => true,
            'data' => [
                'venue_id' => $venue->id,
                'venue_name' => $venue->name,
                'date' => $request->date,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'is_available' => $isAvailable
            ]
        ]);
    }

    public function markUnavailable(Request $request)
    {
        $request->validate([
            'venue_id' => 'required|exists:venues,id',
            'date' => 'required|date|after_or_equal:today',
            'type' => 'required|in:full_day,partial_day',
            'start_time' => 'nullable|required_if:type,partial_day|date_format:H:i',
            'end_time' => 'nullable|required_if:type,partial_day|date_format:H:i|after:start_time',
            'reason' => 'nullable|string|max:500',
        ]);

        try {
            $unavailability = VenueUnavailability::create([
                'venue_id' => $request->venue_id,
                'unavailable_date' => $request->date,
                'type' => $request->type,
                'start_time' => $request->type === 'partial_day' ? $request->start_time : null,
                'end_time' => $request->type === 'partial_day' ? $request->end_time : null,
                'reason' => $request->reason,
                'created_by' => auth()->id(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Venue marked as unavailable successfully',
                'data' => $unavailability
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to mark venue as unavailable: ' . $e->getMessage()
            ], 500);
        }
    }

    public function removeUnavailability(Request $request)
    {
        $request->validate([
            'unavailability_id' => 'required|exists:venue_unavailabilities,id',
        ]);

        try {
            $unavailability = VenueUnavailability::findOrFail($request->unavailability_id);
            $unavailability->delete();

            return response()->json([
                'success' => true,
                'message' => 'Unavailability removed successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove unavailability: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getUnavailabilities(Request $request)
    {
        Log::info('getUnavailabilities called', $request->all());
        
        $request->validate([
            'venue_id' => 'required|exists:venues,id',
            'year' => 'required|integer',
            'month' => 'required|integer|between:1,12',
        ]);

        $unavailabilities = VenueUnavailability::where('venue_id', $request->venue_id)
            ->whereYear('unavailable_date', $request->year)
            ->whereMonth('unavailable_date', $request->month)
            ->get()
            ->map(function ($unavailability) {
                return [
                    'id' => $unavailability->id,
                    'date' => $unavailability->unavailable_date->format('Y-m-d'),
                    'type' => $unavailability->type,
                    'start_time' => $unavailability->start_time?->format('H:i'),
                    'end_time' => $unavailability->end_time?->format('H:i'),
                    'reason' => $unavailability->reason,
                    'created_by' => $unavailability->createdBy?->name ?? 'Unknown',
                ];
            });

        Log::info('Unavailabilities found', ['count' => $unavailabilities->count()]);

        return response()->json([
            'success' => true,
            'data' => $unavailabilities
        ]);
    }

    public function getVenueBookings(Request $request)
    {
        Log::info('getVenueBookings called', $request->all());
        Log::info('User authenticated:', ['user_id' => auth()->id(), 'authenticated' => auth()->check()]);
        
        $request->validate([
            'venue_id' => 'required|exists:venues,id',
            'year' => 'required|integer',
            'month' => 'required|integer|between:1,12',
        ]);

        $bookings = \App\Models\Booking::where(function($query) use ($request) {
                $query->where('venue_id', $request->venue_id)
                      ->orWhere('church_id', $request->venue_id)
                      ->orWhere('reception_id', $request->venue_id);
            })
            ->whereYear('event_date', $request->year)
            ->whereMonth('event_date', $request->month)
            ->whereIn('status', ['approved', 'pending']) // Only consider active bookings
            ->get()
            ->map(function ($booking) {
                return [
                    'id' => $booking->id,
                    'date' => $booking->event_date->format('Y-m-d'),
                    'start_time' => $booking->start_time,
                    'end_time' => $booking->end_time,
                    'event_name' => $booking->event_name,
                    'status' => $booking->status,
                ];
            });

        Log::info('Bookings found', [
            'count' => $bookings->count(),
            'venue_id' => $request->venue_id,
            'year' => $request->year,
            'month' => $request->month,
            'bookings' => $bookings->toArray()
        ]);

        return response()->json([
            'success' => true,
            'data' => $bookings
        ]);
    }

    // ADMIN SIDE
     public function adminIndex(Request $request)
    {
        $query = Venue::with(['spaces', 'gallery']);

        // Apply search filter
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('type', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        // Apply type filter
        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }

        // Apply status filter
        if ($request->has('status') && $request->status != '') {
            $query->where('is_active', $request->status === 'active' ? 1 : 0);
        }

        // Apply sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $venues = $query->paginate(12)->withQueryString();

        return view('admin.list-venues', compact('venues'));
    }

    public function venueMap()
    {
        // Get all active venues with location data
        $venues = Venue::where('is_active', true)
                      ->whereNotNull('latitude')
                      ->whereNotNull('longitude')
                      ->with(['spaces', 'gallery'])
                      ->get();

        return view('admin.venue-map', compact('venues'));
    }

    public function venueCalendar()
    {
        // Get all active venues for the filter dropdown
        $venues = Venue::where('is_active', true)
                      ->orderBy('name')
                      ->get();

        return view('admin.venue-calendar', compact('venues'));
    }

    public function getCalendarBookings(Request $request)
    {
        $year = $request->get('year', date('Y'));
        $month = $request->get('month', date('n'));
        $venueId = $request->get('venue_id');

        // Get bookings for the specified month and year
        $query = \App\Models\Booking::with(['venue', 'user', 'event'])
                                   ->whereYear('event_date', $year)
                                   ->whereMonth('event_date', $month);

        // Filter by venue if specified
        if ($venueId) {
            $query->where('venue_id', $venueId);
        }

        $bookings = $query->get()->map(function ($booking) {
            return [
                'id' => $booking->id,
                'event_name' => $booking->event_name,
                'event_date' => $booking->event_date,
                'event_time' => $booking->start_time . ' - ' . $booking->end_time,
                'venue_name' => $booking->venue->name ?? 'Unknown Venue',
                'venue_id' => $booking->venue_id,
                'client_name' => $booking->user->first_name . ' ' . $booking->user->last_name ?? 'Unknown Client',
                'guest_count' => $booking->guest_count,
                'status' => $booking->status ?? 'pending', 
                'notes' => $booking->additional_notes,
            ];
        });

        return response()->json([
            'success' => true,
            'bookings' => $bookings 
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'capacity' => 'required|integer|min:1',
            'price_range' => 'required|string|max:100',
            'description' => 'required|string',
            'address' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'main_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'spaces' => 'nullable|array',
            'spaces.*.name' => 'required|string|max:255',
            'spaces.*.type' => 'required|string|max:100',
            'spaces.*.capacity' => 'required|integer|min:1',
        ]);

        try {
            // Create img directory if it doesn't exist
            $imgPath = public_path('img');
            if (!file_exists($imgPath)) {
                mkdir($imgPath, 0755, true);
            }
            
            // Handle main image upload to public/img directory
            $mainImage = $request->file('main_image');
            $mainImageName = time() . '_' . $mainImage->getClientOriginalName();
            $mainImagePath = 'public/img/' . $mainImageName;
            $mainImage->move(public_path('img'), $mainImageName);

            // Create venue
            $venue = Venue::create([
                'name' => $request->name,
                'type' => $request->type,
                'capacity' => $request->capacity,
                'price_range' => $request->price_range,
                'description' => $request->description,
                'main_image' => $mainImagePath,
                'address' => $request->address,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'is_active' => true,
            ]);

            // Handle gallery images
            if ($request->hasFile('gallery_images')) {
                // Create gallery directory if it doesn't exist
                $galleryPath = public_path('img/gallery');
                if (!file_exists($galleryPath)) {
                    mkdir($galleryPath, 0755, true);
                }
                
                foreach ($request->file('gallery_images') as $index => $image) {
                    $galleryImageName = time() . '_' . $index . '_' . $image->getClientOriginalName();
                    $galleryImagePath = 'public/img/gallery/' . $galleryImageName;
                    $image->move(public_path('img/gallery'), $galleryImageName);
                    
                    VenueGallery::create([
                        'venue_id' => $venue->id,
                        'image_path' => $galleryImagePath,
                        'sort_order' => $index + 1,
                    ]);
                }
            }

            // Handle venue spaces
            if ($request->has('spaces')) {
                foreach ($request->spaces as $spaceData) {
                    VenueSpace::create([
                        'venue_id' => $venue->id,
                        'name' => $spaceData['name'],
                        'type' => $spaceData['type'],
                        'capacity' => $spaceData['capacity'],
                    ]);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Venue created successfully.',
                'venue' => $venue->load(['spaces', 'gallery'])
            ]);

        } catch (\Exception $e) {
            Log::error('Venue creation failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to create venue: ' . $e->getMessage()
            ], 500);
        }
    }

    public function adminShow(Venue $venue)
    {
        try {
            $venue->load(['spaces', 'gallery']);
            
            return response()->json([
                'success' => true,
                'venue' => $venue
            ]);
        } catch (\Exception $e) {
            Log::error('Venue adminShow failed: ' . $e->getMessage(), [
                'venue_id' => $venue->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to load venue details. Please try again.'
            ], 500);
        }
    }

    public function update(Request $request, Venue $venue)
    {
        Log::info('Venue update request received', [
            'venue_id' => $venue->id,
            'request_data' => $request->all(),
            'files' => $request->hasFile('main_image') ? 'main_image present' : 'no main_image',
            'gallery_files' => $request->hasFile('gallery_images') ? count($request->file('gallery_images')) : 0
        ]);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'capacity' => 'required|integer|min:1',
            'price_range' => 'required|string|max:100',
            'description' => 'required|string',
            'address' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'removed_gallery_images' => 'nullable|array',
            'edit_spaces' => 'nullable|array',
            'edit_spaces.*.name' => 'required|string|max:255',
            'edit_spaces.*.type' => 'required|string|max:100',
            'edit_spaces.*.capacity' => 'required|integer|min:1',
            'new_spaces' => 'nullable|array',
            'new_spaces.*.name' => 'required|string|max:255',
            'new_spaces.*.type' => 'required|string|max:100',
            'new_spaces.*.capacity' => 'required|integer|min:1',
            'removed_venue_spaces' => 'nullable|array',
            'is_active' => 'boolean',
        ]);

        try {
            $data = $request->except(['main_image', 'gallery_images', 'removed_gallery_images', 'edit_spaces', 'new_spaces', 'removed_venue_spaces']);
            
            // Handle is_active field properly
            $data['is_active'] = $request->has('is_active') ? true : false;

            // Handle main image update
            if ($request->hasFile('main_image')) {
                // Delete old image if it exists in public directory
                if ($venue->main_image && file_exists(public_path(str_replace('public/', '', $venue->main_image)))) {
                    unlink(public_path(str_replace('public/', '', $venue->main_image)));
                }
                
                // Create img directory if it doesn't exist
                $imgPath = public_path('img');
                if (!file_exists($imgPath)) {
                    mkdir($imgPath, 0755, true);
                }
                
                // Upload new image
                $mainImage = $request->file('main_image');
                $mainImageName = time() . '_' . $mainImage->getClientOriginalName();
                $mainImagePath = 'public/img/' . $mainImageName;
                $mainImage->move(public_path('img'), $mainImageName);
                $data['main_image'] = $mainImagePath;
            }

            // Handle gallery image removals
            if ($request->has('removed_gallery_images')) {
                $removedImageIds = [];
                
                // Handle both array and comma-separated string formats
                if (is_array($request->removed_gallery_images)) {
                    $removedImageIds = $request->removed_gallery_images;
                } else {
                    // Handle the case where it's a single hidden input with comma-separated values
                    $removedImageIds = array_filter(explode(',', $request->removed_gallery_images));
                }
                
                foreach ($removedImageIds as $imageId) {
                    $imageId = trim($imageId);
                    if (empty($imageId)) continue;
                    
                    $galleryImage = VenueGallery::find($imageId);
                    if ($galleryImage && $galleryImage->venue_id == $venue->id) {
                        // Delete file from public directory
                        if (file_exists(public_path(str_replace('public/', '', $galleryImage->image_path)))) {
                            unlink(public_path(str_replace('public/', '', $galleryImage->image_path)));
                        }
                        $galleryImage->delete();
                    }
                }
            }

            // Handle new gallery images
            if ($request->hasFile('gallery_images')) {
                $existingGalleryCount = $venue->gallery()->count();
                
                // Create gallery directory if it doesn't exist
                $galleryPath = public_path('img/gallery');
                if (!file_exists($galleryPath)) {
                    mkdir($galleryPath, 0755, true);
                }
                
                foreach ($request->file('gallery_images') as $index => $image) {
                    $galleryImageName = time() . '_' . ($existingGalleryCount + $index) . '_' . $image->getClientOriginalName();
                    $galleryImagePath = 'public/img/gallery/' . $galleryImageName;
                    $image->move(public_path('img/gallery'), $galleryImageName);
                    
                    VenueGallery::create([
                        'venue_id' => $venue->id,
                        'image_path' => $galleryImagePath,
                        'sort_order' => $existingGalleryCount + $index + 1,
                    ]);
                }
            }

            // Handle venue spaces updates
            if ($request->has('edit_spaces')) {
                foreach ($request->edit_spaces as $spaceId => $spaceData) {
                    $space = VenueSpace::find($spaceId);
                    if ($space && $space->venue_id == $venue->id) {
                        $space->update([
                            'name' => $spaceData['name'],
                            'type' => $spaceData['type'],
                            'capacity' => $spaceData['capacity'],
                        ]);
                    }
                }
            }

            // Handle new venue spaces
            if ($request->has('new_spaces')) {
                foreach ($request->new_spaces as $spaceData) {
                    VenueSpace::create([
                        'venue_id' => $venue->id,
                        'name' => $spaceData['name'],
                        'type' => $spaceData['type'],
                        'capacity' => $spaceData['capacity'],
                    ]);
                }
            }

            // Handle venue space removals
            if ($request->has('removed_venue_spaces')) {
                $removedSpaceIds = [];
                
                if (is_array($request->removed_venue_spaces)) {
                    $removedSpaceIds = $request->removed_venue_spaces;
                } else {
                    $removedSpaceIds = array_filter(explode(',', $request->removed_venue_spaces));
                }
                
                foreach ($removedSpaceIds as $spaceId) {
                    $spaceId = trim($spaceId);
                    if (empty($spaceId)) continue;
                    
                    $space = VenueSpace::find($spaceId);
                    if ($space && $space->venue_id == $venue->id) {
                        $space->delete();
                    }
                }
            }

            // Update the venue
            $venue->update($data);

            // Update venue_name in all events that reference this venue through bookings
            if (isset($data['name']) && $data['name'] !== $venue->getOriginal('name')) {
                // Get all bookings for this venue
                $bookings = \App\Models\Booking::where('venue_id', $venue->id)->get();
                
                // Update venue_name in all events associated with these bookings
                foreach ($bookings as $booking) {
                    if ($booking->event) {
                        $booking->event->update(['venue_name' => $data['name']]);
                    }
                }
            }

            Log::info('Venue update completed successfully', [
                'venue_id' => $venue->id,
                'updated_data' => $data
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Venue updated successfully.'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Venue update validation failed', [
                'venue_id' => $venue->id,
                'errors' => $e->errors()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Validation failed. Please check your input.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Venue update failed: ' . $e->getMessage(), [
                'venue_id' => $venue->id,
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to update venue: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Venue $venue)
    {
        try {
            // Delete main image from public directory
            if ($venue->main_image && file_exists(public_path(str_replace('public/', '', $venue->main_image)))) {
                unlink(public_path(str_replace('public/', '', $venue->main_image)));
            }

            // Delete gallery images from public directory
            foreach ($venue->gallery as $galleryImage) {
                if (file_exists(public_path(str_replace('public/', '', $galleryImage->image_path)))) {
                    unlink(public_path(str_replace('public/', '', $galleryImage->image_path)));
                }
            }

            $venue->delete();

            return response()->json([
                'success' => true,
                'message' => 'Venue deleted successfully.'
            ]);

        } catch (\Exception $e) {
            Log::error('Venue deletion failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete venue. Please try again.'
            ], 500);
        }
    }

    // MANAGER SIDE (View Only)
    public function managerIndex(Request $request)
    {
        $query = Venue::with(['spaces', 'gallery']);

        // Apply search filter
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('type', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        // Apply type filter
        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }

        // Apply status filter
        if ($request->has('status') && $request->status != '') {
            $query->where('is_active', $request->status === 'active' ? 1 : 0);
        }

        // Apply sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $venues = $query->paginate(12)->withQueryString();

        return view('manager.venues', compact('venues'));
    }

    public function managerVenues(Request $request)
    {
        $query = Venue::with(['spaces', 'gallery']);

        // Apply search filter
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('type', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        // Apply type filter
        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }

        // Apply status filter
        if ($request->has('status') && $request->status != '') {
            $query->where('is_active', $request->status === 'active' ? 1 : 0);
        }

        // Apply sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $venues = $query->paginate(12)->withQueryString();

        return view('manager.venues', compact('venues'));
    }

    public function managerVenueMap()
    {
        $venues = Venue::where('is_active', true)->get();
        return view('manager.venue-map', compact('venues'));
    }

    public function managerVenueCalendar()
    {
        // Get all active venues for the filter dropdown
        $venues = Venue::where('is_active', true)
                      ->orderBy('name')
                      ->get();

        return view('manager.venue-calendar', compact('venues'));
    }

    public function getManagerCalendarBookings(Request $request)
    {
        $year = $request->get('year', date('Y'));
        $month = $request->get('month', date('n'));
        $venueId = $request->get('venue_id');

        // Get bookings for the specified month and year
        $query = \App\Models\Booking::with(['venue', 'user', 'event'])
                                   ->whereYear('event_date', $year)
                                   ->whereMonth('event_date', $month);

        // Filter by venue if specified
        if ($venueId) {
            $query->where('venue_id', $venueId);
        }

        $bookings = $query->get()->map(function ($booking) {
            return [
                'id' => $booking->id,
                'event_name' => $booking->event_name,
                'event_date' => $booking->event_date,
                'event_time' => $booking->start_time . ' - ' . $booking->end_time,
                'venue_name' => $booking->venue->name ?? 'Unknown Venue',
                'venue_id' => $booking->venue_id,
                'client_name' => $booking->user->first_name . ' ' . $booking->user->last_name ?? 'Unknown Client',
                'guest_count' => $booking->guest_count,
                'status' => $booking->status ?? 'pending', 
                'notes' => $booking->additional_notes,
            ];
        });

        return response()->json([
            'success' => true,
            'bookings' => $bookings 
        ]);
    }

    public function showVenue($id)
    {
        $venue = Venue::with(['spaces', 'gallery'])->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'venue' => $venue
        ]);
    }
}