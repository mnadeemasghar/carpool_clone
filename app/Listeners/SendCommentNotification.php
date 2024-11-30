<?php

namespace App\Listeners;

use App\Events\CommentForRideCreated;
use App\Jobs\SendEmailOnNewCommentOnRide;
use Illuminate\Support\Facades\Log;

class SendCommentNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(CommentForRideCreated $event): void
    {
        $details = [
            'ride' => $event->ride,
            'comment' => $event->comment
        ];
        SendEmailOnNewCommentOnRide::dispatch($details);

    }
}
