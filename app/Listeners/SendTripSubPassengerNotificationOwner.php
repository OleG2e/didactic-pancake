<?php

namespace App\Listeners;

use App\Events\TripSubPassengerOwner;
use App\Mail\TripSubPassengerOwner as TripSubPassengerMail;
use Illuminate\Support\Facades\Mail;

class SendTripSubPassengerNotificationOwner
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
     * @param  TripSubPassengerOwner  $event
     * @return void
     */
    public function handle(TripSubPassengerOwner $event)
    {
        Mail::to($event->trip->owner->email)->send(
            new TripSubPassengerMail($event->trip, $event->user)
        );
    }
}
