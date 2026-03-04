<?php

namespace App\Mail;

use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class EventApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Event $event)
    {
        //
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Seu evento foi aprovado ✅',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.event-approved',
            with: [
                'event' => $this->event,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}