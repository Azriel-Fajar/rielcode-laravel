<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProgressNote extends Model
{
    public $timestamps = false;

    protected $fillable = ['order_id', 'note', 'created_at'];

    protected $casts = ['created_at' => 'datetime'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
