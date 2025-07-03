<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VenueUnavailability extends Model
{
    protected $fillable = [
        'venue_id',
        'unavailable_date',
        'start_time',
        'end_time',
        'type',
        'reason',
        'created_by'
    ];

    protected $casts = [
        'unavailable_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
    ];

    public function venue(): BelongsTo
    {
        return $this->belongsTo(Venue::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function isTimeConflict($startTime, $endTime): bool
    {
        if ($this->type === 'full_day') {
            return true; // Full day unavailability conflicts with any time
        }

        // For partial day, check time overlap
        if ($this->start_time && $this->end_time) {
            return !($endTime <= $this->start_time || $startTime >= $this->end_time);
        }

        return false;
    }
}
