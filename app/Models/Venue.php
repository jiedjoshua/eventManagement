<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Venue extends Model
{
    protected $fillable = [
        'name',
        'type',
        'capacity',
        'price_range',
        'description',
        'main_image',
        'address',
        'latitude',
        'longitude',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function spaces(): HasMany
    {
        return $this->hasMany(VenueSpace::class);
    }

    public function gallery(): HasMany
    {
        return $this->hasMany(VenueGallery::class);
    }

     public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function unavailabilities(): HasMany
    {
        return $this->hasMany(VenueUnavailability::class);
    }

    public function isAvailable($date, $startTime, $endTime): bool
    {
        // Check for existing bookings (including church_id and reception_id)
        $conflictingBookings = \App\Models\Booking::where('event_date', $date)
            ->where(function ($query) use ($startTime, $endTime) {
                // Check for time overlap using proper logic
                $query->where(function ($q) use ($startTime, $endTime) {
                    // Case 1: New booking starts during an existing booking
                    $q->where('start_time', '<=', $startTime)
                      ->where('end_time', '>', $startTime);
                })->orWhere(function ($q) use ($startTime, $endTime) {
                    // Case 2: New booking ends during an existing booking
                    $q->where('start_time', '<', $endTime)
                      ->where('end_time', '>=', $endTime);
                })->orWhere(function ($q) use ($startTime, $endTime) {
                    // Case 3: New booking completely contains an existing booking
                    $q->where('start_time', '>=', $startTime)
                      ->where('end_time', '<=', $endTime);
                })->orWhere(function ($q) use ($startTime, $endTime) {
                    // Case 4: New booking is completely within an existing booking
                    $q->where('start_time', '<=', $startTime)
                      ->where('end_time', '>=', $endTime);
                });
            })
            ->where(function ($query) {
                $query->where('venue_id', $this->id)
                      ->orWhere('church_id', $this->id)
                      ->orWhere('reception_id', $this->id);
            })
            ->whereIn('status', ['pending', 'approved'])
            ->get();

        $hasBookingConflict = $conflictingBookings->isNotEmpty();

        // Log debugging information
        \Illuminate\Support\Facades\Log::info('Venue availability check', [
            'venue_id' => $this->id,
            'venue_name' => $this->name,
            'date' => $date,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'has_booking_conflict' => $hasBookingConflict,
            'conflicting_bookings_count' => $conflictingBookings->count(),
            'conflicting_bookings' => $conflictingBookings->map(function($booking) {
                return [
                    'id' => $booking->id,
                    'venue_id' => $booking->venue_id,
                    'church_id' => $booking->church_id,
                    'reception_id' => $booking->reception_id,
                    'start_time' => $booking->start_time,
                    'end_time' => $booking->end_time,
                    'status' => $booking->status
                ];
            })->toArray()
        ]);

        if ($hasBookingConflict) {
            return false;
        }

        // Check for venue unavailabilities
        $hasUnavailability = $this->unavailabilities()
            ->where('unavailable_date', $date)
            ->get()
            ->some(function ($unavailability) use ($startTime, $endTime) {
                return $unavailability->isTimeConflict($startTime, $endTime);
            });

        return !$hasUnavailability;
    }
}