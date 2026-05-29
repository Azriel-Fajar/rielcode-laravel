<?php

namespace App\Mail;

use App\Models\OrderPayment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentReceivedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public OrderPayment $payment) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Payment Received - '.$this->payment->stageLabel().' | Rielcode',
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.payment-received');
    }
}
