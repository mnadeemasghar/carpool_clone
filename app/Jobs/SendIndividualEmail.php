<?php

namespace App\Jobs;

use App\Notifications\AllUsersMailNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class SendIndividualEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    public $mailNotification;
    /**
     * Create a new job instance.
     */
    public function __construct($user, $mailNotification)
    {
        $this->user = $user;
        $this->mailNotification = $mailNotification;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Notification::send($this->user, new AllUsersMailNotification($this->mailNotification));
    }
}
