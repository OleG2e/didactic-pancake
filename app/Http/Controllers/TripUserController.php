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
        $this->middleware(['auth', 'verified']);
    }

    public function addUser(Trip $trip)
    {
        if (!$this->availability($trip)) {
            return back()->with(flash('Мест нет'));
        }
        $user = auth()->user();
        $user->trips()->attach($trip);
        $trip->decrement('passengers_count');
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
        event(new TripSubPassengerOwner($trip, $user));
        event(new TripSubPassengerCompanion($trip, $user));
        flash('Вы отказались от поездки');
        return back();
    }

    private function availability(Trip $trip)
    {
        return ($trip->passengers_count - $trip->users()->count()) > 0 ? true : false;
    }
}