<?php

namespace App\Listeners;

use App\Events\ReplyCreated;
use App\Mail\ReplyCreated as ReplyCreatedMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendReplyCreatedNotification
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
     * @param ReplyCreated $event
     * @return void
     */
    public function handle(ReplyCreated $event)
    {
        Mail::to($event->reply->post->owner->email)->send(
            new ReplyCreatedMail($event->reply)
        );
    }
}
