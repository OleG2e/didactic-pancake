<?php

namespace App\Http\Controllers;

use App\Post;
use App\Category;
use App\Reply;
use Illuminate\Http\Request;

class PostController extends Controller
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
        $post = Post::all();

        return view('post.index', compact('post'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('post.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Post $post, Category $category)
    {
        $attributes = $this->validatePost();
        $attributes['owner_id'] = auth()->id();
        $post->create($attributes);
        flash('Post создан');
        return redirect('/post');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post, Reply $reply)
    {
        return view('post.show', ['post' => $post, 'reply' => $reply]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post, Category $category)
    {
        $categories = Category::all();
        return view('post.edit', [
            'post' => $post,
            'categories' => $categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $post->update($this->validatePost());
        return redirect('/post');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post $post
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Post $post)
    {
        $post->delete();
        flash('Post удален');
        return redirect('/post');
    }

    protected function validatePost()
    {
        return request()->validate([
            'category_id' => 'required|integer',
            'title' => 'required',
            'description' => 'required',
        ]);
    }
}
