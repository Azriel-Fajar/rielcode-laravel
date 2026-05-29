<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $fillable = [
        'question', 'answer',
        'show_on_studio', 'show_on_services',
        'is_visible', 'sort_order',
    ];

    protected $casts = [
        'show_on_studio' => 'boolean',
        'show_on_services' => 'boolean',
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

    public function scopeStudio($q)
    {
        return $q->where('show_on_studio', true);
    }

    public function scopeServices($q)
    {
        return $q->where('show_on_services', true);
    }
}
