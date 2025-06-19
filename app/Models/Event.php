<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_name',
        'event_type',
        'package_type',
        'event_date',
        'start_time',
        'end_time',
        'venue_name',
        'event_duration',
        'guest_count',
        'guest_list_path',
        'enable_rsvp',
        'rsvp_deadline',
        'allow_plus_one',
        'reminder_schedule',
        'total_price',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('rsvp_status', 'plus_one')
            ->withTimestamps();
    }

    // In Event.php
    public function guests()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('rsvp_status', 'plus_one', 'checked_in_at')
            ->withTimestamps();
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
