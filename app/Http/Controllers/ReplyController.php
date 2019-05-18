<?php

namespace App\Http\Controllers;

use App\Mail\RequestLinkFromUser;
use App\Reply;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;

class ReplyController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Reply  $reply
     * @return Response
     */
    public function store(Reply $reply)
    {
        $attributes = request()->validate([
            'post_id' => 'required|numeric',
            'category_id' => 'required|numeric',
            'description' => 'required|string',
        ]);
        $attributes['owner_id'] = auth()->id();
        $reply->create($attributes);
        flash('Ответ создан');

        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Reply  $reply
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Reply $reply)
    {
        $this->authorize('update', $reply);

        return view('subview.reply-edit-form', compact('reply'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  Reply  $reply
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Reply $reply)
    {
        $this->authorize('update', $reply);
        $reply->update($request->validate(['description' => 'required|string']));

        switch ($reply->category->slug) {
            case 'trip':
                return redirect(route('trip.show', $reply->post_id));
                break;
            case 'delivery':
                return redirect(route('delivery.show', $reply->post_id));
                break;
            default:
                return redirect(route('post.show', $reply->post_id));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Reply  $reply
     * @return Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Reply $reply)
    {
        $this->authorize('delete', $reply);

        $reply->delete();
        flash('Ответ удалён');

        return back();
    }

    public function linkRequest(Reply $reply)
    {
        switch ($reply->category->id) {
            case 2:
                $route = route('trip.show', ['posts' => $reply->post_id]);
                break;
            case 3:
                $route = route('delivery.show', ['posts' => $reply->post_id]);
                break;
            default:
                $route = route('post.show', ['posts' => $reply->post_id]);
        }

        Mail::to($reply->owner->email)->send(new RequestLinkFromUser($route));
        flash("Запрос отправлен {$reply->owner->name}");
        return back();
    }
}
