<?php

namespace App\Mail;

use App\Models\OrderPayment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvoiceSentMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public OrderPayment $payment) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Invoice ' . $this->payment->invoice_number . ' from Rielcode',
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.invoice-sent');
    }
}
