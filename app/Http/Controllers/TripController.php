<?php

namespace App\Http\Controllers;

use App\Events\TripCreated;
use App\Http\Requests\TripRequest;
use App\Town;
use App\Trip;
use App\Reply;
use Illuminate\Auth\Access\AuthorizationException;
use DateTime;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TripController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified'])->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $trips = Trip::whereRelevance(true)->where('passengers_count', '>', 0)->oldest('date_time')->get();

        return view('trips.index', compact('trips'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        $towns = Town::all();

        return view('trips.create', compact(['towns']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Trip  $trip
     * @param  TripRequest  $request
     * @return RedirectResponse
     * @throws \Exception
     */
    public function store(Trip $trip, TripRequest $request): RedirectResponse
    {
        $attributes = $request->validated();
        $attributes['date_time'] = new DateTime($attributes['date'].' '.$attributes['time']);
        $attributes['owner_id'] = auth()->id();
        $attributes['category_id'] = 2;
        $createdTrip = $trip->create($attributes);
        $user = auth()->user();
        $user->trips()->attach($createdTrip);
        event(new TripCreated($createdTrip));
        flash('Поездка создана');

        return redirect('/trips');
    }

    /**
     * Display the specified resource.
     *
     * @param  Trip  $trip
     * @param  Reply  $reply
     * @return View
     */
    public function show(Trip $trip, Reply $reply): View
    {
        return view('trips.show', compact(['trip', 'reply']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Trip  $trip
     * @return View
     * @throws AuthorizationException
     */
    public function edit(Trip $trip): View
    {
        $this->authorize('update', $trip);

        $towns = Town::all();
        $dateTime = new DateTime($trip->date_time);

        return view('trips.edit', compact(['trip', 'towns', 'dateTime']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  TripRequest  $request
     * @param  Trip  $trip
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(TripRequest $request, Trip $trip): RedirectResponse
    {
        $this->authorize('update', $trip);

        $attributes = $request->validated();
        $attributes['date_time'] = new DateTime($attributes['date'].' '.$attributes['time']);
        $trip->update($attributes);
        flash('Поездка изменена');

        return redirect(route('trip.show', $trip));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Trip  $trip
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(Trip $trip): RedirectResponse
    {
        $this->authorize('delete', $trip);

        $replies = Reply::where('model_id', $trip->id)->get();
        $trip->users()->detach();
        foreach ($replies as $reply) {
            $reply->delete();
        }
        $trip->delete();
        flash('Поездка удалена');

        return redirect(route('trip.all'));
    }
}