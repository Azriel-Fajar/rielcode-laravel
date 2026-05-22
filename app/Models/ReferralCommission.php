<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReferralCommission extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'referrer_id', 'order_id', 'order_amount', 'commission_amount', 'status', 'paid_at',
    ];

    protected $casts = ['paid_at' => 'datetime'];

    public function referrer()
    {
        return $this->belongsTo(Referrer::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
