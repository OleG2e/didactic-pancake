<?php

namespace App\Http\Controllers;

use App\Events\TripAddPassengerCompanion;
use App\Events\TripAddPassengerOwner;
use App\Events\TripSubPassengerOwner;
use App\Events\TripSubPassengerCompanion;
use App\Trip;
use Illuminate\Http\Request;

class TripUserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'throttle:5,5']);
    }

    public function addUser(Trip $trip)
    {
        $user = auth()->user();
        $user->trips()->attach($trip);
        $trip->decrement('passengers_count');
        if ($trip->passengers_count === 0) {
            $trip->relevance = false;
        }
        $trip->save();

        event(new TripAddPassengerOwner($trip, $user));
        event(new TripAddPassengerCompanion($trip, $user));
        flash('Вы присоединились к поездке');

        return back();
    }

    public function removeUser(Trip $trip)
    {
        $user = auth()->user();
        $user->trips()->detach($trip);
        $trip->increment('passengers_count');
        if ($trip->relevance == false) {
            $trip->relevance = true;
        }
        $trip->save();

        event(new TripSubPassengerOwner($trip, $user));
        event(new TripSubPassengerCompanion($trip, $user));
        flash('Вы отказались от поездки');

        return back();
    }
}