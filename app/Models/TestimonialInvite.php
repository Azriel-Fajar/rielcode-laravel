<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestimonialInvite extends Model
{
    public $timestamps = false;

    protected $fillable = ['token', 'label', 'used_at', 'testimonial_id'];

    protected $casts = ['used_at' => 'datetime'];

    public function testimonial()
    {
        return $this->belongsTo(Testimonial::class);
    }
}
