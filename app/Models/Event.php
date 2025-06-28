<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
protected $fillable = [
        'user_id',
        'booking_id', 
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
        'status',
        'cancel_reason',
        'cancelled_at',
        'approved_at',
        'rejected_at',
        'completed_at'
    ];

    protected $casts = [
        'event_date' => 'date',
        'start_time' => 'string',
        'end_time' => 'string',
        'rsvp_deadline' => 'date',
        'enable_rsvp' => 'boolean',
        'allow_plus_one' => 'boolean',
        'cancelled_at' => 'datetime',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
        'completed_at' => 'datetime',
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

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }

    public function venue()
    {
        return $this->hasOneThrough(
            \App\Models\Venue::class,
            \App\Models\Booking::class,
            'id', // Foreign key on bookings table
            'id', // Foreign key on venues table
            'booking_id', // Local key on events table
            'venue_id' // Local key on bookings table
        );
    }
}
