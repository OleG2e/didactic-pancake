<?php

namespace App\Events;

use App\ReplyPost;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;

class ReplyPostCreated
{
    use Dispatchable, SerializesModels;

    public $reply;

    /**
     * Create a new event instance.
     *
     * @param  ReplyPost  $reply
     */
    public function __construct(ReplyPost $reply)
    {
        $this->reply = $reply;
    }

}
