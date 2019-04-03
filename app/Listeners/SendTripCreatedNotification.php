<?php

namespace App\Listeners;

use App\Events\TripCreated;
use App\Mail\TripCreated as TripCreatedMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendTripCreatedNotification
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
     * @param TripCreated $event
     * @return void
     */
    public function handle(TripCreated $event)
    {
        Mail::to($event->trip->owner->email)->send(
            new TripCreatedMail($event->trip)
        );
    }
}
