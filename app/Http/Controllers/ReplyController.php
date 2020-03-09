<?php

namespace App\Http\Controllers;

use App\Delivery;
use App\Http\Requests\ReplyRequest;
use App\Mail\RequestLinkFromUser;
use App\Reply;
use App\Trip;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ReplyController extends Controller
{
    private function routeSwitcher(string $model_name, Reply $reply): string
    {
        switch ($model_name) {
            case Trip::MODEL_NAME:
                return route('trip.show', $reply->model_id);
                break;
            case Delivery::MODEL_NAME:
                return route('delivery.show', $reply->model_id);
                break;
            default:
                return route('post.show', [$reply->parent($model_name)->category->slug, $reply->model_id]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  string  $model_name
     * @param  int  $model_id
     * @param  Reply  $reply
     * @param  ReplyRequest  $request
     * @return RedirectResponse
     */
    public function store(string $model_name, int $model_id, Reply $reply, ReplyRequest $request): RedirectResponse
    {
        $attributes = $request->validated();
        $attributes['owner_id'] = auth()->id();
        $attributes['model_id'] = $model_id;
        $attributes['model_name'] = $model_name;
        $reply->create($attributes);
        flash('Ответ создан');

        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $model_name
     * @param  int  $model_id
     * @param  Reply  $reply
     * @return View
     * @throws AuthorizationException
     */
    public function edit(string $model_name, int $model_id, Reply $reply): View
    {
        $this->authorize('update', $reply);

        return view('components.reply-edit-form', compact(['model_name', 'model_id', 'reply']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  string  $model_name
     * @param  int  $model_id
     * @param  Reply  $reply
     * @param  ReplyRequest  $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(string $model_name, int $model_id, Reply $reply, ReplyRequest $request): RedirectResponse
    {
        $this->authorize('update', $reply);

        $reply->update($request->validated());

        return redirect($this->routeSwitcher($model_name, $reply));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $model_name
     * @param  int  $model_id
     * @param  Reply  $reply
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(string $model_name, int $model_id, Reply $reply): RedirectResponse
    {
        $this->authorize('delete', $reply);

        $reply->delete();
        flash('Ответ удалён');

        return back();
    }

    public function linkRequest(string $model_name, int $model_id, Reply $reply): RedirectResponse
    {
        $route = $this->routeSwitcher($model_name, $reply);

        Mail::to($reply->owner->email)->send(new RequestLinkFromUser($route));
        flash("Запрос отправлен {$reply->owner->name}");
        return back();
    }
}
