<?php

namespace App\Listeners;

use App\Notifications\RideMatchNotification;
use App\Services\RideService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendEmailToTheMatchingUsersWhichHaveSamePickDropAndTime
{
    protected $rideService;
    /**
     * Create the event listener.
     */
    public function __construct(RideService $rideService)
    {
        $this->rideService = $rideService;
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $ride = $event->ride;

        // pick location id
        $pick_location_id = $ride->pick_location_id;

        // drop location id
        $drop_location_id = $ride->drop_location_id;

        // get all active rides with the same pick and drop
        $users = $this->rideService->getUserEmailsFromActiveRidesByPickAndDrop($ride, $pick_location_id, $drop_location_id);

        $details = [
            'ride' => $ride,
        ];
        
        Notification::send($users, new RideMatchNotification($details));
    }
}
