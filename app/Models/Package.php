<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Package extends Model
{
    protected $fillable = [
        'name',
        'type',
        'title',
        'price',
        'base_price',
        'description',
        'is_active'
    ];

    public function features(): HasMany
    {
        return $this->hasMany(PackageFeature::class)->orderBy('sort_order');
    }

     public function packageFeatures(): HasMany
    {
        return $this->hasMany(PackageFeature::class);
    }
}