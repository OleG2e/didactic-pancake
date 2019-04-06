<?php

namespace App\Http\Controllers;

use App\Category;
use App\Town;
use App\Trip;
use App\ReplyTrip;
use Illuminate\Http\Request;
use DateTime;
use Illuminate\Http\Response;

class TripController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $trips = Trip::where('relevance', true)->where('passengers_count', '>', 0)->oldest('date_time')->get();

        return view('trips.index', compact('trips'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $categories = Category::all();
        $towns = Town::all();
        return view('trips.create', compact(['towns', 'categories']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Trip  $trip
     * @return Response
     * @throws \Exception
     */
    public function store(Trip $trip)
    {
        $attributes = $this->validateTrip();
        $attributes['date_time'] = $attributes['date'] . ' ' . $attributes['time'];
        unset($attributes['date']);
        unset($attributes['time']);
        $attributes['date_time'] = new DateTime($attributes['date_time']);
        $attributes['owner_id'] = auth()->id();
        $trip->create($attributes);
        flash('Post создан');
        return redirect('/trips');
    }

    /**
     * Display the specified resource.
     *
     * @param Trip $trip
     * @return Response
     */
    public function show(Trip $trip, ReplyTrip $reply)
    {
        return view('trips.show', compact(['trip', 'reply']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Trip $trip
     * @return Response
     */
    public function edit(Trip $trip)
    {
        $categories = Category::all();
        return view('trips.edit', compact(['trip', 'categories']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Trip $trip
     * @return Response
     */
    public function update(Request $request, Trip $trip)
    {
        $trip->update($this->validateTrip());
        return redirect('/trips');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Trip $trip
     * @return Response
     */
    public function destroy(Trip $trip)
    {
        $replies = ReplyTrip::where('trip_id', $trip->id)->get();
        foreach ($replies as $reply) {
            $reply->delete();
        }
        $trip->delete();
        flash('Post удален');
        return redirect('/trips');
    }

    protected function validateTrip()
    {
        return request()->validate([
            'category_id' => 'required|integer',
            'startpoint_id' => 'required|integer',
            'endpoint_id' => 'required|integer',
            'passengers_count' => 'nullable|integer',
            'date' => 'required',
            'time' => 'required',
            'description' => 'string|nullable',
            'load' => 'nullable',
        ]);
    }
}
