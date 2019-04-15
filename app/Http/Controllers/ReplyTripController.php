<?php

namespace App\Http\Controllers;

use App\Trip;
use App\ReplyTrip;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReplyTripController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ReplyTrip  $reply
     * @return Response
     */
    public function store(ReplyTrip $reply)
    {
        $attributes = $this->validateReply();
        $attributes['owner_id'] = auth()->id();
        $reply->create($attributes);
        flash('Ответ создан');
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  ReplyTrip  $reply
     * @return Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(ReplyTrip $reply)
    {
        $this->authorize('update', $reply);
        return view(''); //TODO: make view
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  ReplyTrip  $reply
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, ReplyTrip $reply)
    {
        $this->authorize('update', $reply);
        //TODO: make view
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ReplyTrip  $reply
     * @return Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(ReplyTrip $reply)
    {
        $this->authorize('delete', $reply);
        $reply->delete();
        flash('Ответ удален');
        return back();
    }

    protected function validateReply()
    {
        return request()->validate([
            'trip_id' => 'required|numeric',
            'description' => 'required',
        ]);
    }
}
