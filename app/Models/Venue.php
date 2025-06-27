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
        'rating',
        'description',
        'main_image',
        'address',
        'latitude',
        'longitude',
        'is_active'
    ];

    protected $casts = [
        'price_range' => 'decimal:2',
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

    public function isAvailable($date, $startTime, $endTime): bool
    {
        return !$this->bookings()
            ->where('event_date', $date)
            ->where(function ($query) use ($startTime, $endTime) {
                $query->where(function ($q) use ($startTime, $endTime) {
                    // Check if any existing booking overlaps with the requested time
                    $q->whereBetween('start_time', [$startTime, $endTime])
                        ->orWhereBetween('end_time', [$startTime, $endTime]);
                })->orWhere(function ($q) use ($startTime, $endTime) {
                    // Check if the requested time is within an existing booking
                    $q->where('start_time', '<=', $startTime)
                        ->where('end_time', '>=', $endTime);
                });
            })
            ->whereIn('status', ['pending', 'approved'])
            ->exists();
    }
}