<?php

namespace App\Http\Controllers;

use App\Town;
use Illuminate\Http\Request;

class TownController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $towns = Town::all();

        return view('towns.index', compact('towns'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('towns.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Town $town)
    {
        $attributes = $this->validateTown();
        $town->create($attributes);
        flash('Town created');
        return redirect('/towns');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Town $town
     * @return \Illuminate\Http\Response
     */
    public function show(Town $town)
    {
        return view('towns.show', compact('town'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Town $town
     * @return \Illuminate\Http\Response
     */
    public function edit(Town $town)
    {
        return view('towns.edit', compact('town'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Town $town
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Town $town)
    {
        $town->update($this->validateTown());
        return redirect('/towns');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Town $town
     * @return \Illuminate\Http\Response
     */
    public function destroy(Town $town)
    {
        $town->delete();
        return redirect('/towns');
    }

    protected function validateTown()
    {
        return request()->validate([
            'title' => 'required|string|unique:towns|max:255',
        ]);
    }
}
