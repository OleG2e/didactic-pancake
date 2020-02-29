<?php

namespace App\Http\Controllers;

use App\Mail\RequestLinkFromUser;
use App\Reply;
use App\Town;
use App\Trip;
use Illuminate\Http\Request;
use DateTime;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;

class DeliveryController extends Controller
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
        $deliveries = Trip::whereRelevance(true)->where('category_id', 3)->oldest('date_time')->get();

        return view('deliveries.index', compact('deliveries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $towns = Town::all();

        return view('deliveries.create', compact(['towns']));
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
        $attributes = $this->validateDelivery();
        $attributes['category_id'] = 3;
        $attributes['passengers_count'] = 0;
        $attributes['price'] = 0;
        $attributes['date_time'] = new DateTime($attributes['date']);
        $attributes['owner_id'] = auth()->id();
        $trip->create($attributes);
        flash('Передачка создана');

        return redirect('/deliveries');
    }

    /**
     * Display the specified resource.
     *
     * @param  Trip  $trip
     * @return Response
     */
    public function show(Trip $trip)
    {
        return view('deliveries.show', compact(['trip']));
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

        $towns = Town::all();
        $dateTime = new DateTime($trip->date_time);

        return view('deliveries.edit', compact(['trip', 'towns', 'dateTime']));
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

        $attributes = $this->validateDelivery();
        $attributes['date_time'] = $attributes['date'];
        unset($attributes['date']);
        $attributes['date_time'] = new DateTime($attributes['date_time']);
        $trip->update($attributes);
        flash('Передачка изменена');

        return redirect(route('delivery.show', $trip));
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
        $replies = Reply::where('post_id', $trip->id)->where('category_id', 3)->get();
        foreach ($replies as $reply) {
            $reply->delete();
        }
        $trip->delete();
        flash('Передачка удалена');

        return redirect(route('delivery.all'));
    }

    protected function validateDelivery()
    {
        return request()->validate([
            'startpoint_id' => 'required|integer',
            'endpoint_id' => 'required|integer',
            'date' => 'required|date',
            'description' => 'required|string',
        ]);
    }

    public function linkRequest(Trip $trip)
    {
        $route = route('delivery.show', $trip->id);
        Mail::to($trip->owner->email)->send(new RequestLinkFromUser($route));
        flash("Запрос отправлен {$trip->owner->name}");

        return back();
    }
}