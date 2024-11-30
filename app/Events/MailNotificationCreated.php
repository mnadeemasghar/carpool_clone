<?php

namespace App\Events;

use App\Models\MailNotification;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MailNotificationCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $mailNotification;
    /**
     * Create a new event instance.
     */
    public function __construct(MailNotification $mailNotification)
    {
        $this->mailNotification = $mailNotification;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
