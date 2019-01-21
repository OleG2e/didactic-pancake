<?php

namespace App\Http\Controllers;

use App\Category;
use App\Trip;
use App\Reply;
use Illuminate\Http\Request;

class TripController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trip = Trip::all();

        return view('trip.index', compact('trip'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('trip.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Trip $trip)
    {
        $attributes = $this->validateTrip();
        $attributes['owner_id'] = auth()->id();
        $trip->create($attributes);
        flash('Post создан');
        return redirect('/trip');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Trip $trip
     * @return \Illuminate\Http\Response
     */
    public function show(Trip $trip, Reply $reply)
    {
        return view('trip.show', ['trip' => $trip, 'reply' => $reply]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Trip $trip
     * @return \Illuminate\Http\Response
     */
    public function edit(Trip $trip)
    {
        $categories = Category::all();
        return view('trip.edit', [
            'trip' => $trip,
            'categories' => $categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Trip $trip
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Trip $trip)
    {
        $trip->update($this->validateTrip());
        return redirect('/trip');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Trip $trip
     * @return \Illuminate\Http\Response
     */
    public function destroy(Trip $trip)
    {
        $replies = Reply::where('post_id', $trip->id)->get();
        foreach ($replies as $reply) {
            $reply->delete();
        }
        $trip->delete();
        flash('Post удален');
        return redirect('/trip');
    }

    protected function validateTrip()
    {
        return request()->validate([
            'category_id' => 'required|integer',
            'date_time' => 'required',
            'description' => 'string|nullable',
            'load' => 'nullable',
        ]);
    }
}
