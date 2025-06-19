<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'venue_id',
        'package_id',
         'reference',
        'event_name',
        'event_type',
        'event_date',
        'start_time',
        'end_time',
        'guest_count',
        'venue_notes',
        'additional_notes',
        'selected_addons',
        'package_price_at_booking',
        'addons_price_at_booking',
        'total_price',
        'status',
        'rejection_reason'
    ];

    protected $casts = [
        'event_date' => 'date',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
        'selected_addons' => 'array',
        'package_price_at_booking' => 'decimal:2',
        'addons_price_at_booking' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function venue(): BelongsTo
    {
        return $this->belongsTo(Venue::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function event(): HasOne
    {
        return $this->hasOne(Event::class);
    }

    // Method to get selected addons
    public function getSelectedAddons()
    {
        if (!$this->selected_addons) {
            return collect();
        }
        return Addon::whereIn('id', $this->selected_addons)->get();
    }

    public function calculateTotalPrice(): void
    {
        // Get the package price
        $this->package_price_at_booking = $this->package->base_price;
        
        // Calculate addons price
        if ($this->selected_addons) {
            $this->addons_price_at_booking = Addon::whereIn('id', $this->selected_addons)
                ->sum('price');
        }
        
        // Set total price
        $this->total_price = $this->package_price_at_booking + $this->addons_price_at_booking;
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

     protected static function boot()
    {
        parent::boot();
        
        // Generate reference number before creating a new booking
        static::creating(function ($booking) {
            $booking->reference = $booking->generateReference();
        });
    }

    public function generateReference(): string
    {
        // Get the last booking ID and increment by 1
        $lastId = static::max('id') ?? 0;
        $nextId = $lastId + 1;
        return 'EVT-' . date('Y') . '-BK-' . str_pad($nextId, 6, '0', STR_PAD_LEFT);
    }
}