<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MailNotificationEmail extends Mailable
{
    use Queueable, SerializesModels;
    protected $mailNotification;
    protected $user;
    /**
     * Create a new message instance.
     */
    public function __construct($user, $mailNotification)
    {
        $this->mailNotification = $mailNotification;
        $this->user = $user;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->user->name . ", " . $this->mailNotification->subject,
        );
    }

    public function build()
    {
        return $this->view('emails.email-to-users')
                    ->with([
                        'user' => $this->user,
                        'body' => $this->mailNotification->body,
                    ]);
    }
}
