<?php

namespace App\Mail;

use App\Reply;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReplyCreatedOwner extends Mailable
{
    use Queueable, SerializesModels;


    public $reply;

    /**
     * Create a new message instance.
     *
     * @param $reply
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
            ->markdown('emails.reply-created');
    }
}