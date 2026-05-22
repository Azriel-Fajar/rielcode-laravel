<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TestimonialThankYouMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public array $testimonialData) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Thank you for your review, ' . ($this->testimonialData['client_name'] ?? 'friend') . '!',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.testimonial-thankyou',
        );
    }
}
