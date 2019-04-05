<?php

namespace App\Events;

use App\Trip;
use App\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;

class TripSubPassengerOwner
{
    use Dispatchable, SerializesModels;

    public $trip;
    public $user;

    /**
     * Create a new event instance.
     *
     * @param  Trip  $trip
     */
    public function __construct(Trip $trip, User $user)
    {
        $this->trip = $trip;
        $this->user = $user;
    }

}
