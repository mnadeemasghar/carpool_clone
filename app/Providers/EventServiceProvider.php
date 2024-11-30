<?php

namespace App\Providers;

use App\Events\CommentForRideCreated;
use App\Events\MailNotificationCreated;
use App\Events\RideRequestCreated;
use App\Listeners\SendCommentNotification;
use App\Listeners\SendEmailToTheMatchingUsersWhichHaveSamePickDropAndTime;
use App\Listeners\SendMailNotificationToAllUsers;
use App\Listeners\SendNewRideNotificationToAdmins;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        RideRequestCreated::class => [
            SendEmailToTheMatchingUsersWhichHaveSamePickDropAndTime::class,
            SendNewRideNotificationToAdmins::class
        ],
        MailNotificationCreated::class => [
            SendMailNotificationToAllUsers::class
        ],
        CommentForRideCreated::class => [
            SendCommentNotification::class
        ]
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
