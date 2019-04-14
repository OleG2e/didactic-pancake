<?php

namespace App\Mail;

use DateInterval;
use DateTime;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Spatie\CalendarLinks\Link;

class TripCreated extends Mailable
{
    use Queueable, SerializesModels;


    public $trip;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($trip)
    {
        $this->trip = $trip;
    }

    private function attachCalendar()
    {
        $dt = $this->trip->date_time;
        $from = clone $dt;
        $to = $dt->add(new DateInterval('PT2H'));
        $link = Link::create('Поездка в ' . $this->trip->endpoint->title, $from, $to)
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
            ->markdown('emails.trip-created')
            ->attachData($this->attachCalendar(), 'event.ics')
            ->with(['date' => $this->trip->date_time]);
    }
}