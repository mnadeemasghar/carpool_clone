<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class InspireQuoteNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $quote;

    /**
     * Create a new notification instance.
     */
    public function __construct($quote)
    {
        // Store the fetched quote
        $this->quote = $quote;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        // Define the channels: email, database, or broadcasting
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        if(!empty($this->quote) && !empty($this->quote[0])){
            return (new MailMessage)
                        ->line("Quote of the day!")
                        ->line($this->quote[0]['quote'])
                        ->line(' — ' . $this->quote[0]['author'])
                        ->action('Visit us', url('/'))
                        ->line('Thank you for using our application!');
                    }
        else{
            return (new MailMessage)
                        ->line("Quote of the day!")
                        ->line("No quote for today")
                        ->line("Sometime we have to take space!")
                        ->action('Visit us', url('/'))
                        ->line('Thank you for using our application!');

        }
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
