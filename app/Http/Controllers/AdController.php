<?php

namespace App\Http\Controllers;

use App\Ad;
use App\Category;
use Illuminate\Http\Request;

class AdController extends Controller
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
        $ad = Ad::all();

        return view('ad.index', compact('ad'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('ad.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Ad $ad, Category $category)
    {
        $attributes = $this->validateAd();
        $attributes['owner_id'] = auth()->id();
        $ad->create($attributes);
        flash('Объявление создано');
        return redirect('/ad');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ad $ad
     * @return \Illuminate\Http\Response
     */
    public function show(Ad $ad)
    {
        return view('ad.show', compact('ad'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ad $ad
     * @return \Illuminate\Http\Response
     */
    public function edit(Ad $ad, Category $category)
    {
        $categories = Category::all();
        return view('ad.edit', [
            'ad' => $ad,
            'categories' => $categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Ad $ad
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ad $ad)
    {
        $ad->update($this->validateAd());
        return redirect('/ad');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ad $ad
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Ad $ad)
    {
        $ad->delete();
        flash('Объявление удалено');
        return redirect('/ad');
    }

    protected function validateAd()
    {
        return request()->validate([
            'category_id' => 'required|integer',
            'description' => 'required',
        ]);
    }
}
