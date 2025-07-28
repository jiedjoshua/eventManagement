<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExternalGuest extends Model
{
    protected $fillable = [
        'event_id',
        'name',
        'unique_code',
        'checked_in_at',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
} 