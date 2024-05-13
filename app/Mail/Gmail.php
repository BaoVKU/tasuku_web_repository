<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class Gmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $userMail;
    public $subject;
    public $data;
    public $attachmentsPath;
    public function __construct($userMail, $subject, $data, $attachmentsPath = [])
    {
        $this->userMail = $userMail;
        $this->subject = $subject;
        $this->data = $data;
        $this->attachmentsPath = $attachmentsPath;
    }
    public function getUserMail()
    {
        return $this->userMail;
    }
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {

        return new Envelope(
            from: new Address('thisisbaomail@gmail.com', $this->userMail),
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'gmail.viewer',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $attachments = [];
        foreach ($this->attachmentsPath as $path) {
            $attachments[] = Attachment::fromPath($path);
        }
        return $attachments;
    }
}
