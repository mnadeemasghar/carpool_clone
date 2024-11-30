<?php

namespace App\Jobs;

use App\Models\Ride;
use App\Models\User;
use App\Notifications\NewCommentOnRide;
use App\Notifications\NewCommentOnRideWhichUserInvolved;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class SendEmailOnNewCommentOnRide implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $details;
    /**
     * Create a new job instance.
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $ride = Ride::find($this->details['ride']['id']);
        $rideOwner = User::find($this->details['ride']['user_id']); // Use find() instead of get() for a single user
        // If the commenter is not the ride owner
        if($this->details['ride']['user_id'] != $this->details['comment']['user_id']){
            Notification::send($rideOwner, new NewCommentOnRide($this->details));
        } 
        else {
            // Get the IDs of users who have commented on the ride, excluding the current commenter
            $commenter_ids = $ride->commentors()
                                    ->where('user_id', '!=', $this->details['comment']['user_id'])
                                    ->pluck('user_id');
        
            // Fetch users and send notification
            $commenters = User::whereIn('id', $commenter_ids)->get();
            Notification::send($commenters, new NewCommentOnRideWhichUserInvolved($this->details));
        }
    }
}
