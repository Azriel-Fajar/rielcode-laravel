<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageAddon extends Model
{
    protected $fillable = [
        'name', 'description', 'price_idr', 'price_usd', 'type',
        'is_visible', 'sort_order',
    ];

    protected $casts = [
        'is_visible' => 'boolean',
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
