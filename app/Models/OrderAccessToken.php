<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderAccessToken extends Model
{
    public $timestamps = false;

    protected $fillable = ['order_id', 'token', 'deactivated_at'];

    protected $casts = ['deactivated_at' => 'datetime'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function isActive(): bool
    {
        return $this->deactivated_at === null;
    }
}
