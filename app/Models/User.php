<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Event;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'phone_number',
        'email',
        'password',
        'role', 
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Optional: Accessor for full name
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Get the user's role value
     */
    public function getRoleAttribute(): string
    {
        return $this->attributes['role'] ?? 'regular_user';
    }


    /**
     * Boot function from Laravel.
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($user) {
            if (!isset($user->role)) {
                $user->role = 'regular_user';
            }
        });
    }

    public function bookings()
    {
        return $this->hasMany(Event::class);
    }

    public function invitedEvents()
    {
        return $this->belongsToMany(Event::class)->withPivot('rsvp_status', 'plus_one')->withTimestamps();
    }

    public function guests()
    {
        return $this->belongsToMany(User::class)->withPivot('rsvp_status', 'plus_one')->withTimestamps();
    }

    public function acceptedEvents()
    {
        return $this->invitedEvents()->wherePivot('rsvp_status', 'accepted');
    }

}
