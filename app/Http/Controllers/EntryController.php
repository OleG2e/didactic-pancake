<?php

namespace App\Http\Controllers;

use App\Entry;
use App\Category;
use App\ReplyPost;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EntryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $entries = Entry::where('relevance', true)->latest()->get();

        return view('entries.index', compact('entries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('entries.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Entry $entry, Category $category)
    {
        $attributes = $this->validatePost();
        $attributes['owner_id'] = auth()->id();
        $entry->create($attributes);
        flash('Post создан');
        return redirect('/entries');
    }

    /**
     * Display the specified resource.
     *
     * @param Post $post
     * @return Response
     */
    public function show(Entry $entry, ReplyPost $reply)
    {
        return view('entries.show', compact(['entry', 'reply']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Post $post
     * @return Response
     */
    public function edit(Entry $entry, Category $category)
    {
        $categories = Category::all();
        return view('posts.edit', compact(['entry', 'categories']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Post $post
     * @return Response
     */
    public function update(Request $request, Entry $entry)
    {
        $entry->update($this->validateEntry());
        return redirect('/entries');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Post $post
     * @return Response
     * @throws Exception
     */
    public function destroy(Entry $entry)
    {
        $replies = ReplyPost::where('post_id', $entry->id)->get();
        foreach ($replies as $reply) {
            $reply->delete();
        }
        $entry->delete();
        flash('Post удален');
        return back();
    }

    protected function validateEntry()
    {
        return request()->validate([
            'category_id' => 'required|integer',
            'title' => 'required',
            'description' => 'required',
        ]);
    }
}