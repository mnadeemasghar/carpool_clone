<?php

namespace App\Jobs;

use App\Models\Admin;
use App\Models\User;
use App\Notifications\InspireQuoteNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class SendInspireQuoteToAllUsers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $quote;
    /**
     * Create a new job instance.
     */
    public function __construct($quote)
    {
        $this->quote = $quote;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

       if (isset($this->quote['error'])) {
           return;
       }
       else{    
            $admins = Admin::pluck('user_id');
            $users = User::whereIn('id',$admins)->where('email_verified_at','!=',null)->get();
            Notification::send($users, new InspireQuoteNotification($this->quote));
       }
    }
}
