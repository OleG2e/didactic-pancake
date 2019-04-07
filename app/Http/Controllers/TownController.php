<?php

namespace App\Http\Controllers;

use App\Town;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TownController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $this->authorize('create', auth()->user());
        $towns = Town::all();

        return view('towns.index', compact('towns'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $this->authorize('create', auth()->user());
        return view('towns.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Town $town)
    {
        $this->authorize('create', auth()->user());
        $attributes = $this->validateTown();
        $town->create($attributes);
        flash('Town created');
        return redirect('/towns');
    }

    /**
     * Display the specified resource.
     *
     * @param Town $town
     * @return Response
     */
    public function show(Town $town)
    {
        $this->authorize('create', auth()->user());
        return view('towns.show', compact('town'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Town $town
     * @return Response
     */
    public function edit(Town $town)
    {
        $this->authorize('create', auth()->user());
        return view('towns.edit', compact('town'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Town $town
     * @return Response
     */
    public function update(Request $request, Town $town)
    {
        $this->authorize('create', auth()->user());
        $town->update($this->validateTown());
        return redirect('/towns');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Town $town
     * @return Response
     */
    public function destroy(Town $town)
    {
        $this->authorize('create', auth()->user());
        $town->delete();
        return redirect('/towns');
    }

    protected function validateTown()
    {
        $this->authorize('create', auth()->user());
        return request()->validate([
            'title' => 'required|string|unique:towns|max:255',
        ]);
    }
}
