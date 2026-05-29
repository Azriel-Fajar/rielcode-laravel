<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BriefCompleteMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Order $order,
        public string $progressUrl
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Project is Underway - '.$this->order->order_name,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.brief-complete',
        );
    }
}
