<?php

namespace App\Listeners;

use App\Events\TripSubPassengerCompanion;
use App\Mail\TripSubPassengerCompanion as TripSubPassengerMail;
use Illuminate\Support\Facades\Mail;

class SendTripSubPassengerNotificationCompanion
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
     * @param  TripSubPassengerCompanion  $event
     * @return void
     */
    public function handle(TripSubPassengerCompanion $event)
    {
        Mail::to($event->user->email)->send(
            new TripSubPassengerMail($event->trip, $event->user)
        );
    }
}
