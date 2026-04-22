<?php

namespace App\Mail;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewContactMessageNotification extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public ContactMessage $contactMessage,
        public string $locale,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('messages.contact_notification_subject', [
                'subject' => $this->contactMessage->subject,
            ], $this->locale),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact.new-message',
        );
    }
}
