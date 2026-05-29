<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderPayment extends Model
{
    protected $fillable = [
        'order_id', 'stage', 'invoice_number', 'amount', 'currency',
        'status', 'due_date', 'notes', 'sent_at', 'paid_at',
    ];

    protected $casts = [
        'due_date' => 'date',
        'sent_at' => 'datetime',
        'paid_at' => 'datetime',
        'amount' => 'decimal:2',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function isDeposit(): bool
    {
        return $this->stage === 'deposit';
    }

    public function stageLabel(): string
    {
        return $this->stage === 'deposit' ? 'Deposit (20%)' : 'Final (80%)';
    }

    public function stageTagline(): string
    {
        return $this->stage === 'deposit'
            ? 'This is the 20% deposit. Project work begins once this payment is received.'
            : 'This is the final 80%. Admin credentials and project handover follow once cleared.';
    }

    public function amountFormatted(): string
    {
        return $this->currency === 'IDR'
            ? 'Rp '.number_format($this->amount, 0, ',', '.')
            : '$'.number_format($this->amount, 2);
    }

    public function publicUrl(): string
    {
        return route('invoice.show', $this->invoice_number);
    }
}
