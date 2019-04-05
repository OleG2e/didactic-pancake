<?php

namespace App\Listeners;

use App\Events\TripAddPassengerOwner;
use App\Mail\TripAddPassengerOwner as TripAddPassengerMail;
use Illuminate\Support\Facades\Mail;

class SendTripAddPassengerNotificationOwner
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  TripAddPassengerOwner  $event
     * @return void
     */
    public function handle(TripAddPassengerOwner $event)
    {
        Mail::to($event->trip->owner->email)->send(
            new TripAddPassengerMail($event->trip, $event->user)
        );
    }
}
