<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'order_name', 'email', 'package', 'package_id', 'custom_preset',
        'copy_source_url', 'custom_config', 'owns_domain', 'owns_hosting',
        'phone_number', 'description', 'status', 'project_stage', 'staging_url',
        'invoice_number', 'invoice_file', 'invoice_sent', 'invoice_status',
        'invoice_amount', 'invoice_currency', 'invoice_due_date', 'invoice_notes',
        'invoice_line_items', 'selected_addons', 'package_price', 'addons_total', 'final_price',
        'payment_method', 'referral_code', 'created_at',
    ];

    protected $casts = [
        'custom_config' => 'array',
        'invoice_line_items' => 'array',
        'selected_addons' => 'array',
        'created_at' => 'datetime',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }

    public function accessTokens()
    {
        return $this->hasMany(OrderAccessToken::class);
    }

    public function progressNotes()
    {
        return $this->hasMany(OrderProgressNote::class);
    }

    public function referralCommissions()
    {
        return $this->hasMany(ReferralCommission::class);
    }

    public function payments()
    {
        return $this->hasMany(OrderPayment::class);
    }

    public function depositPayment()
    {
        return $this->hasOne(OrderPayment::class)->where('stage', 'deposit');
    }

    public function finalPayment()
    {
        return $this->hasOne(OrderPayment::class)->where('stage', 'final');
    }
}
