<?php

namespace App\Mail;

use App\ReplyPost;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReplyCreatedOwnerPost extends Mailable
{
    use Queueable, SerializesModels;


    public $reply;

    /**
     * Create a new message instance.
     *
     * @param $reply
     */
    public function __construct(ReplyPost $reply)
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
        return $this->from(env('MAIL_FROM_ADDRESS'))
            ->markdown('emails.reply-post-created');
    }
}