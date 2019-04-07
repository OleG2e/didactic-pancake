<?php

namespace App\Http\Controllers;

use App\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
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
        $this->authorize('view', auth()->user());
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $this->authorize('create', auth()->user());
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Category $category
     * @return Response
     */
    public function store(Category $category)
    {
        $this->authorize('update', auth()->user());
        $attributes = $this->validateCategory();
        $category->create($attributes);
        flash(true);
        return redirect('/categories');
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @return Response
     */
    public function show(Category $category)
    {
        $this->authorize('view', auth()->user());
        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Category $category
     * @return Response
     */
    public function edit(Category $category)
    {
        $this->authorize('update', auth()->user());
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Category $category
     * @return Response
     */
    public function update(Request $request, Category $category)
    {
        $this->authorize('update', auth()->user());
        $category->update($this->validateCategory());
        return redirect('/categories');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return Response
     * @throws Exception
     */
    public function destroy(Category $category)
    {
        $this->authorize('delete', auth()->user());
        $category->delete();
        return redirect('/categories');
    }

    protected function validateCategory()
    {
        return request()->validate([
            'title' => 'required|string|unique:categories|max:255',
        ]);
    }
}
