<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageAddon extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'price_idr', 'price_usd', 'type',
        'tiers', 'is_visible', 'sort_order',
    ];

    protected $casts = [
        'is_visible' => 'boolean',
        'tiers' => 'array',
    ];

    public function scopeVisible($q)
    {
        return $q->where('is_visible', true);
    }

    public function scopeOrdered($q)
    {
        return $q->orderBy('sort_order')->orderBy('id');
    }
}
