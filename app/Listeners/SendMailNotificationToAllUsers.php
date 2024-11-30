<?php

namespace App\Listeners;

use App\Jobs\SendEmailsToAllUsers;
use App\Jobs\SendIndividualEmail;
use App\Models\User;

class SendMailNotificationToAllUsers
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
    public function handle(object $event): void
    {
        $mailNotification = $event->mailNotification;

        // SendEmailsToAllUsers::dispatch($mailNotification);
        
        
        // Dispatch the job to handle sending emails with a 10-second delay between each
        $users = User::all();
        foreach($users as $user){
            SendIndividualEmail::dispatch($user,$mailNotification)->delay(now()->addSeconds(10));
        }

    }
}
