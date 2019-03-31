<?php

namespace App\Http\Controllers;

use App\Trip;
use App\User;
use Illuminate\Http\Request;

class TripUserController extends Controller
{
    public function addUser(Trip $trip)
    {
        if (!$this->availability($trip)) {
            return back()->with(flash('Мест нет'));
        }
        $authUser = auth()->user();
        $authUser->trips()->attach($trip);
        return back();
    }

    public function removeUser(Trip $trip)
    {
        $authUser = auth()->user();
        $authUser->trips()->detach($trip);
        return back();
    }

    private function availability(Trip $trip)
    {
        return ($trip->passengers_count - $trip->users()->count()) > 0 ? true : false;
    }
}
