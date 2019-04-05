<?php

namespace App\Http\Controllers;

use App\Trip;
use App\ReplyTrip;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReplyTripController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(ReplyTrip $reply)
    {
        $attributes = $this->validateReply();
        $attributes['owner_id'] = auth()->id();
        $reply->create($attributes);
        flash('Reply создан');
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  ReplyTrip  $reply
     * @return Response
     */
    public function edit(ReplyTrip $reply)
    {
        dd(phpinfo());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  ReplyPost  $reply
     * @return Response
     */
    public function update(Request $request, ReplyTrip $reply)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ReplyPost  $reply
     * @return Response
     */
    public function destroy(ReplyTrip $reply)
    {
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
