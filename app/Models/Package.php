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
        'is_popular', 'badge_color', 'blurb', 'features_json', 'included_addons', 'included_tiers',
        'is_visible', 'sort_order', 'orders',
    ];

    protected $casts = [
        'includes_free_hosting' => 'boolean',
        'includes_free_domain' => 'boolean',
        'is_popular' => 'boolean',
        'is_visible' => 'boolean',
        'features_json' => 'array',
        'included_addons' => 'array',
        'included_tiers' => 'array',
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

    public function idrShort(): string
    {
        if ($this->idr_price < 1000000) {
            return number_format($this->idr_price / 1000).'k';
        }

        $jt = round(($this->idr_price / 1000000) * 2) / 2;

        return rtrim(rtrim(number_format($jt, 1, ',', '.'), '0'), ',').'jt';
    }

    public function features(): array
    {
        $data = $this->features_json ?? [];

        // Flat shape (admin panel): features_json.items
        if (! empty($data['items'])) {
            return $data['items'];
        }

        // Nested shape (legacy seeder): features_json.sections[].items
        $items = [];
        foreach ($data['sections'] ?? [] as $section) {
            foreach ($section['items'] ?? [] as $item) {
                $items[] = $item;
            }
        }

        return $items;
    }

    public function deliveryLabel(): string
    {
        if ($this->delivery_days_min === $this->delivery_days_max) {
            return $this->delivery_days_min.' days';
        }

        return $this->delivery_days_min.' to '.$this->delivery_days_max.' days';
    }
}
