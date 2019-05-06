<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class RequestLinkFromUser extends Mailable
{
    use Queueable, SerializesModels;

    public $route;

    /**
     * Create a new message instance.
     *
     * @param $post
     */
    public function __construct($route)
    {
        $this->route = $route;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'))
            ->markdown('emails.link-request-owner');
    }
}