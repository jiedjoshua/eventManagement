<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    // Fillable fields based on your migration
    protected $fillable = [
        'title',
        'description',
        'location',
        'date',
        'start_time',
        'end_time',
        'status',
        'created_by',
    ];

    /**
     * The users who have booked this event (attendees).
     * Many-to-many relationship with User via pivot table 'event_user'.
     */
    public function attendees()
    {
        return $this->belongsToMany(User::class, 'event_user')
                    ->withPivot('status', 'booked_at') // add these if you track booking status/time
                    ->withTimestamps();
    }

    /**
     * The user who created (manages) the event.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
