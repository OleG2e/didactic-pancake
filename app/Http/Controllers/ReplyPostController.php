<?php

namespace App\Http\Controllers;

use App\Post;
use App\ReplyPost;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReplyPostController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(ReplyPost $reply)
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
     * @param  ReplyPost  $reply
     * @return Response
     */
    public function edit(ReplyPost $reply)
    {
        $this->authorize('update', $reply);
        //TODO: view
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  ReplyPost  $reply
     * @return Response
     */
    public function update(Request $request, ReplyPost $reply)
    {
        $this->authorize('update', $reply);
        //TODO: view
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ReplyPost  $reply
     * @return Response
     */
    public function destroy(ReplyPost $reply)
    {
        $this->authorize('delete', $reply);
        $reply->delete();
        flash('Ответ удален');
        return back();
    }

    protected function validateReply()
    {
        return request()->validate([
            'post_id' => 'required|numeric',
            'description' => 'required',
        ]);
    }
}
