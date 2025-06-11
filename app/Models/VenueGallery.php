<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VenueGallery extends Model
{
    protected $table = 'venue_gallery';

    protected $fillable = [
        'venue_id',
        'image_path',
        'sort_order'
    ];

    public function venue(): BelongsTo
    {
        return $this->belongsTo(Venue::class);
    }
}