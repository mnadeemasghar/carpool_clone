<?php

namespace App\Listeners;

use App\Jobs\SendEmailToAdminsOnNewRide;
use App\Models\Admin;
use App\Models\User;

class SendNewRideNotificationToAdmins
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
        $ride = $event->ride;

        // Admin Users
        // get Admin Ids
        $admins = Admin::pluck('user_id');
        $users = User::whereIn('id',$admins)->get();

        $details = [
            'ride' => $ride,
            'users' => $users
        ];

        SendEmailToAdminsOnNewRide::dispatch($details);

    }
}
