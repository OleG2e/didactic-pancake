<?php

namespace App\Listeners;

use App\Events\ReplyTripCreated;
use App\Mail\ReplyCreatedOwnerTrip as ReplyCreatedMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendReplyCreatedNotificationTrip
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
     * @param  ReplyTripCreated  $event
     * @return void
     */
    public function handle(ReplyTripCreated $event)
    {
        Mail::to($event->reply->trip->owner->email)->send(
            new ReplyCreatedMail($event->reply)
        );
    }
}
