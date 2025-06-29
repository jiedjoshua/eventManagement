<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomePageContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'section',
        'title',
        'subtitle',
        'description',
        'image_path',
        'button_text',
        'button_link',
        'service_cards',
        'contact_phone',
        'contact_email',
        'contact_address',
        'is_active'
    ];

    protected $casts = [
        'service_cards' => 'array',
        'is_active' => 'boolean'
    ];

    /**
     * Get content by section
     */
    public static function getBySection($section)
    {
        return static::where('section', $section)->where('is_active', true)->first();
    }

    /**
     * Get all active content
     */
    public static function getAllActive()
    {
        return static::where('is_active', true)->get()->keyBy('section');
    }
} 