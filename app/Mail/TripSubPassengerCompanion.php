<?php

namespace App\Mail;

use App\Trip;
use App\User;
use DateTime;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TripSubPassengerCompanion extends Mailable
{
    use Queueable, SerializesModels;


    public $trip;
    public $user;

    /**
     * Create a new message instance.
     *
     * @param  Trip  $trip
     * @param  User  $user
     * @throws \Exception
     */
    public function __construct(Trip $trip, User $user)
    {
        $this->trip = $trip;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'))
            ->markdown('emails.trip-sub-passenger-companion')
            ->with(['date' => new DateTime($this->trip->date_time)]);
    }
}