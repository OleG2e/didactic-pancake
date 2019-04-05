<?php

namespace App\Listeners;

use App\Events\ReplyPostCreated;
use App\Mail\ReplyCreatedOwnerPost as ReplyCreatedMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendReplyCreatedNotificationPost
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
     * @param  ReplyPostCreated  $event
     * @return void
     */
    public function handle(ReplyPostCreated $event)
    {
        Mail::to($event->reply->post->owner->email)->send(
            new ReplyCreatedMail($event->reply)
        );
    }
}
