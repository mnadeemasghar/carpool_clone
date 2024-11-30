<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewRideNotification extends Notification
{
    use Queueable;

    protected $ride;

    /**
     * Create a new notification instance.
     */
    public function __construct($details)
    {
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
            ->subject('New Ride Created | '.
                        $this->ride->user->name.
                        " | From: ".$this->ride->pick_location->title.
                        " To: ".$this->ride->drop_location->title)
            ->line('Pick Location: ' . $this->ride->pick_location->title)
            ->line('Pick Time: ' . $this->ride->pick_time)
            ->line('Drop Location: ' . $this->ride->drop_location->title)
            ->line('Return Time: ' . $this->ride->return_time)
            ->line('Start Date: ' . $this->ride->start_date)
            ->line('End Date: ' . $this->ride->end_date)
            ->line('Trip Type: ' . $this->ride->trip_type)
            ->line('Offer: ' . $this->ride->offer)
            ->line('User: ' . $this->ride->user->name)
            ->line('User Phone: ' . $this->ride->user->phone)
            ->line('User Email: ' . $this->ride->user->email)
            ->line('Vehicle Type: ' . $this->ride->vehicle_type)
            ->line('Role: ' . $this->ride->role)
            ->line('Monday: ' . $this->ride->mon)
            ->line('Tuesday: ' . $this->ride->tue)
            ->line('Wednesday: ' . $this->ride->wed)
            ->line('Thursday: ' . $this->ride->thu)
            ->line('Friday: ' . $this->ride->fri)
            ->line('Saturday: ' . $this->ride->sat)
            ->line('Sunday: ' . $this->ride->sun)
            ->line('Status: ' . $this->ride->status)
            ->line('Note: ' . $this->ride->note);
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
