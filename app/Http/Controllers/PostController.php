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
        $posts = Post::all();

        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('posts.create', compact('categories'));
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
        return redirect('/posts');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post, Reply $reply)
    {
        return view('posts.show', ['post' => $post, 'reply' => $reply]);
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
        return view('posts.edit', [
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
        return redirect('/posts');
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
        $replies = Reply::where('post_id', $post->id)->get();
        foreach ($replies as $reply) {
            $reply->delete();
        }
        $post->delete();
        flash('Post удален');
        return redirect('/posts');
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
