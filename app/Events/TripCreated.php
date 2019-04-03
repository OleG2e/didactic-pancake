<?php

namespace App\Events;

use App\Trip;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;

class TripCreated
{
    use Dispatchable, SerializesModels;

    public $trip;

    /**
     * Create a new event instance.
     *
     * @param Trip $trip
     */
    public function __construct(Trip $trip)
    {
        $this->trip = $trip;
    }

}
