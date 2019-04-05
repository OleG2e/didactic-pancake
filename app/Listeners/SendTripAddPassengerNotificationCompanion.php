<?php

namespace App\Listeners;

use App\Events\TripAddPassengerCompanion;
use App\Mail\TripAddPassengerCompanion as TripAddPassengerMail;
use Illuminate\Support\Facades\Mail;

class SendTripAddPassengerNotificationCompanion
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
     * @param  TripAddPassengerCompanion  $event
     * @return void
     */
    public function handle(TripAddPassengerCompanion $event)
    {
        Mail::to($event->trip->owner->email)->send(
            new TripAddPassengerMail($event->trip, $event->user)
        );
    }
}
