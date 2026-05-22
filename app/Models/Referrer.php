<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Referrer extends Model
{
    public $timestamps = false;

    protected $fillable = ['name', 'phone', 'code', 'commission_rate', 'status'];

    public function commissions()
    {
        return $this->hasMany(ReferralCommission::class);
    }
}
