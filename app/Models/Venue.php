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

    public function spaces(): HasMany
    {
        return $this->hasMany(VenueSpace::class);
    }

    public function gallery(): HasMany
    {
        return $this->hasMany(VenueGallery::class);
    }
}