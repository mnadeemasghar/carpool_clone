<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewCommentOnRide extends Notification
{
    use Queueable;

    protected $comment;
    protected $ride;

    /**
     * Create a new notification instance.
     */
    public function __construct($details)
    {
        $this->comment = $details['comment'];
        $this->ride = $details['ride'];
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Comment from ' . $this->comment->user->name)
            ->greeting('Hello!')
            ->line('We wanted to let you know that someone just commented on your ride.')
            ->line('**User Name:** ' . $this->comment->user->name)
            ->line('**Comment:** "' . $this->comment->body . '"')
            ->action('View All Comments', route('ride.show', ['ride' => $this->ride]))
            ->line('Thank you for being a valued member of our community!');

    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
