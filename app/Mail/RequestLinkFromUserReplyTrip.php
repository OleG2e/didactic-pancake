<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class RequestLinkFromUserReplyTrip extends Mailable
{
    use Queueable, SerializesModels;

    public $reply;

    /**
     * Create a new message instance.
     *
     * @param $post
     */
    public function __construct($reply)
    {
        $this->reply = $reply;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'))
            ->markdown('emails.trip-reply-link-request-owner');
    }
}