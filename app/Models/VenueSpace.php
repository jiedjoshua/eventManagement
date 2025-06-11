<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VenueSpace extends Model
{
    protected $fillable = [
        'venue_id',
        'name',
        'type',
        'capacity',
        'icon'
    ];

    public function venue(): BelongsTo
    {
        return $this->belongsTo(Venue::class);
    }
}