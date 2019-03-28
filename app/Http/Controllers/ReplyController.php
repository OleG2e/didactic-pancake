<?php

namespace App\Http\Controllers;

use App\Post;
use App\Reply;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Reply $reply, Post $post)
    {
        $attributes = $this->validateReply();
        $attributes['owner_id'] = auth()->id();
        $reply->create($attributes);
        flash('Reply создан');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param Reply $reply
     * @return Response
     */
    public function show(Reply $reply)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Reply $reply
     * @return Response
     */
    public function edit(Reply $reply)
    {
        dd(phpinfo());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Reply $reply
     * @return Response
     */
    public function update(Request $request, Reply $reply)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Reply $reply
     * @return Response
     */
    public function destroy(Reply $reply)
    {
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
