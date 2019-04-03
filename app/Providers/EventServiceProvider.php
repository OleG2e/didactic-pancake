<?php

namespace App\Providers;

use App\Events\TripCreated;
use App\Events\ReplyCreated;
use App\Listeners\SendTripCreatedNotification;
use App\Listeners\SendReplyCreatedNotification;
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

        ReplyCreated::class => [
            SendReplyCreatedNotification::class
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
