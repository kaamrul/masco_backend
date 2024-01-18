<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class DefaultMail extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public $subject;
    public $body_message;

    public function __construct(string $subject, string $message)
    {
        $this->subject = $subject;
        $this->body_message = $message;
    }

    public function envelope()
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    public function content()
    {
        return new Content(
            view: 'email.default',
        );
    }

    public function attachments()
    {
        return [];
    }
}
