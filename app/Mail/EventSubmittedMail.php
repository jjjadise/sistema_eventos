<?php

namespace App\Mail;

use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class EventSubmittedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Event $event)
    {
        //
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Recebemos seu evento 🎉',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.event-submitted',
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