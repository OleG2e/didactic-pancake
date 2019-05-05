<?php

namespace App\Events;

use App\Reply;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;

class ReplyCreated
{
    use Dispatchable, SerializesModels;

    public $reply;

    /**
     * Create a new event instance.
     *
     * @param  Reply  $reply
     */
    public function __construct(Reply $reply)
    {
        $this->reply = $reply;
    }

}
