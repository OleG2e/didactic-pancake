<?php

namespace App\Events;

use App\ReplyTrip;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;

class ReplyTripCreated
{
    use Dispatchable, SerializesModels;

    public $reply;

    /**
     * Create a new event instance.
     *
     * @param  ReplyTrip  $reply
     */
    public function __construct(ReplyTrip $reply)
    {
        $this->reply = $reply;
    }

}
