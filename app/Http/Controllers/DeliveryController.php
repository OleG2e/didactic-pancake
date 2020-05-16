<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\DeliveryRequest;
use App\Mail\RequestLinkFromUser;
use App\Reply;
use App\Town;
use App\Delivery;
use DateTime;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use App\Helpers;

class DeliveryController extends Controller
{
    private object $categories;
    private object $towns;

    public function __construct()
    {
        $this->middleware(['auth', 'verified'])->except(['index', 'show']);
        $this->categories = Category::whereSection(Delivery::MODEL_NAME)->get();
        $this->towns = Town::all();
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $deliveries = Delivery::whereRelevance(true)->where('date_time', '>', now())->oldest()->get();

        return view('deliveries.index', compact('deliveries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('deliveries.create', ['towns' => $this->towns, 'categories' => $this->categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Delivery  $delivery
     * @param  DeliveryRequest  $request
     * @return RedirectResponse
     * @throws \Exception
     */
    public function store(Delivery $delivery, DeliveryRequest $request): RedirectResponse
    {
        $attributes = $request->validated();
        $attributes['owner_id'] = auth()->id();
        $delivery->create($attributes);

        Helpers::flash('Передачка создана');

        return redirect(route('delivery.all'));
    }

    /**
     * Display the specified resource.
     *
     * @param  Delivery  $delivery
     * @return View
     * @throws \Exception
     */
    public function show(Delivery $delivery): View
    {
        return view('deliveries.show', compact(['delivery']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Delivery  $delivery
     * @return View
     * @throws AuthorizationException
     */
    public function edit(Delivery $delivery): View
    {
        $this->authorize('update', $delivery);

        return view(
            'deliveries.edit',
            [
                'categories' => $this->categories,
                'delivery' => $delivery,
                'towns' => $this->towns,
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Delivery  $delivery
     * @param  DeliveryRequest  $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(Delivery $delivery, DeliveryRequest $request): RedirectResponse
    {
        $this->authorize('update', $delivery);

        $attributes = $request->validated();
        $delivery->update($attributes);
        Helpers::flash('Передачка изменена');

        return redirect(route('delivery.show', $delivery));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Delivery  $delivery
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(Delivery $delivery): RedirectResponse
    {
        $this->authorize('delete', $delivery);

        $replies = Reply::where('model_id', $delivery->id)->where('model_name', Delivery::MODEL_NAME)->get();
        foreach ($replies as $reply) {
            $reply->delete();
        }
        $delivery->delete();
        Helpers::flash('Передачка удалена');

        return redirect(route('delivery.all'));
    }

    public function linkRequest(Delivery $delivery)
    {
        $route = route('delivery.show', $delivery->id);
        Mail::to($delivery->owner->email)->send(new RequestLinkFromUser($route));
        Helpers::flash("Запрос отправлен {$delivery->owner->username}");

        return back();
    }
}