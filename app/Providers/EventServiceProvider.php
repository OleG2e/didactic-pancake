<?php

namespace App\Providers;

use App\Events\ReplyPostCreated;
use App\Events\ReplyTripCreated;
use App\Events\TripCreated;
use App\Events\TripAddPassengerOwner;
use App\Events\TripAddPassengerCompanion;
use App\Events\TripSubPassengerOwner;
use App\Events\TripSubPassengerCompanion;
use App\Listeners\SendReplyCreatedNotificationTrip;
use App\Listeners\SendReplyCreatedNotificationPost;
use App\Listeners\SendTripCreatedNotification;
use App\Listeners\SendTripAddPassengerNotificationOwner;
use App\Listeners\SendTripAddPassengerNotificationCompanion;
use App\Listeners\SendTripSubPassengerNotificationOwner;
use App\Listeners\SendTripSubPassengerNotificationCompanion;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        TripCreated::class => [
            SendTripCreatedNotification::class
        ],

        ReplyTripCreated::class => [
            SendReplyCreatedNotificationTrip::class
        ],

        ReplyPostCreated::class => [
            SendReplyCreatedNotificationPost::class
        ],

        TripAddPassengerCompanion::class => [
            SendTripAddPassengerNotificationCompanion::class
        ],
        TripAddPassengerOwner::class => [
            SendTripAddPassengerNotificationOwner::class
        ],

        TripSubPassengerCompanion::class => [
            SendTripSubPassengerNotificationCompanion::class
        ],

        TripSubPassengerOwner::class => [
            SendTripSubPassengerNotificationOwner::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
