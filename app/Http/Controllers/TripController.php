<?php

namespace App\Http\Controllers;

use App\Category;
use App\Mail\RequestLinkFromUser;
use App\Town;
use App\Trip;
use App\Reply;
use App\User;
use Illuminate\Http\Request;
use DateTime;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;

class TripController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified'])->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $trips = Trip::whereRelevance(true)->where('passengers_count', '>', 0)->oldest('date_time')->get();

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
        $attributes['date_time'] = $attributes['date'].' '.$attributes['time'];
        unset($attributes['date']);
        unset($attributes['time']);
        $attributes['date_time'] = new DateTime($attributes['date_time']);
        $attributes['owner_id'] = auth()->id();
        $attributes['category_id'] = 2;
        $createdTrip = $trip->create($attributes);
        $user = auth()->user();
        $user->trips()->attach($createdTrip);
        flash('Поездка создана');

        return redirect('/trips');
    }

    /**
     * Display the specified resource.
     *
     * @param  Trip  $trip
     * @return Response
     */
    public function show(Trip $trip, Reply $reply)
    {
        return view('trips.show', compact(['trip', 'reply']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Trip  $trip
     * @return Response
     * @throws \Exception
     */
    public function edit(Trip $trip)
    {
        $this->authorize('update', $trip);

        $categories = Category::all();
        $towns = Town::all();
        $dateTime = new DateTime($trip->date_time);

        return view('trips.edit', compact(['trip', 'categories', 'towns', 'dateTime']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  Trip  $trip
     * @return Response
     * @throws \Exception
     */
    public function update(Request $request, Trip $trip)
    {
        $this->authorize('update', $trip);

        $attributes = $this->validateTrip();
        $attributes['date_time'] = $attributes['date'].' '.$attributes['time'];
        unset($attributes['date']);
        unset($attributes['time']);
        $attributes['date_time'] = new DateTime($attributes['date_time']);
        $trip->update($attributes);
        flash('Поездка изменена');

        return redirect(route('trip.show', $trip));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Trip  $trip
     * @return Response
     */
    public function destroy(Trip $trip)
    {
        $this->authorize('delete', $trip);

        $replies = Reply::where('post_id', $trip->id)->get();
        $trip->users()->detach();
        foreach ($replies as $reply) {
            $reply->delete();
        }
        $trip->delete();
        flash('Поездка удалена');

        return redirect(route('trip.all'));
    }

    public function linkRequest(Trip $post)
    {
        $route = route('delivery.show', ['trip' => $post->id]);
        Mail::to($post->owner->email)->send(new RequestLinkFromUser($route));
        flash("Запрос отправлен {$post->owner->name}");

        return back();
    }

    protected function validateTrip()
    {
        return request()->validate([
            'startpoint_id' => 'required|integer',
            'endpoint_id' => 'required|integer',
            'passengers_count' => 'nullable|integer',
            'price' => 'required|string',
            'date' => 'required',
            'time' => 'required',
            'description' => 'string|nullable',
        ]);
    }
}