<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'slug', 'package_name', 'idr_price', 'us_price', 'original_idr', 'original_us',
        'delivery_days_min', 'delivery_days_max',
        'includes_free_hosting', 'includes_free_domain',
        'is_popular', 'badge_color', 'blurb', 'features_json',
        'is_visible', 'sort_order', 'orders',
    ];

    protected $casts = [
        'includes_free_hosting' => 'boolean',
        'includes_free_domain'  => 'boolean',
        'is_popular'            => 'boolean',
        'is_visible'            => 'boolean',
        'features_json'         => 'array',
    ];

    public function scopeVisible($q)
    {
        return $q->where('is_visible', true);
    }

    public function scopeOrdered($q)
    {
        return $q->orderBy('sort_order')->orderBy('id');
    }

    public function ordersRel()
    {
        return $this->hasMany(Order::class, 'package_id');
    }

    public function deliveryLabel(): string
    {
        if ($this->delivery_days_min === $this->delivery_days_max) {
            return $this->delivery_days_min . ' days';
        }
        return $this->delivery_days_min . ' to ' . $this->delivery_days_max . ' days';
    }
}
