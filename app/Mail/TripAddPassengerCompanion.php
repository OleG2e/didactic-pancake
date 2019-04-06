<?php

namespace App\Mail;

use App\Trip;
use App\User;
use DateTime;
use DateInterval;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Spatie\CalendarLinks\Link;

class TripAddPassengerCompanion extends Mailable
{
    use Queueable, SerializesModels;


    public $trip;
    public $user;

    /**
     * Create a new message instance.
     *
     * @param  Trip  $trip
     * @param  User  $user
     */
    public function __construct(Trip $trip, User $user)
    {
        $this->trip = $trip;
        $this->user = $user;
    }

    private function attachCalendar()
    {
        $dt = new DateTime($this->trip->date_time);
        $from = clone $dt;
        $to = $dt->add(new DateInterval('PT2H'));
        $link = Link::create('Поездка в '.$this->trip->endpoint->title, $from, $to)
            ->description('Хорошей дороги!');
        return $link->ics();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'))
            ->markdown('emails.trip-add-passenger-companion')
            ->attachData($this->attachCalendar(), 'event.ics');
    }
}