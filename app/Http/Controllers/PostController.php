<?php

namespace App\Http\Controllers;

use App\Mail\RequestLinkFromUserPost;
use App\Mail\ResponseLinkToUser;
use App\Post;
use App\Category;
use App\ReplyPost;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified'])->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $posts = Post::where('relevance', true)->latest()->get();
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Post $post, Request $request)
    {
        $images = json_encode($this->imageUpload($request));
        $attributes = $this->validatePost();
        $attributes['owner_id'] = auth()->id();
        $attributes['images'] = $images;
        $post->create($attributes);
        flash('Post создан');
        return redirect('/posts');
    }

    /**
     * Display the specified resource.
     *
     * @param  Post  $post
     * @return Response
     */
    public function show(Post $post, ReplyPost $reply)
    {
        if (isset($post->images)) {
            $imagesAll = json_decode($post->images);

            return view('posts.show', compact(['reply', 'post', 'imagesAll']));
        }
        return view('posts.show', compact(['reply', 'post']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Post  $post
     * @return Response
     */
    public function edit(Post $post, Category $category)
    {
        $this->authorize('update', $post);
        $categories = Category::all();
        return view('posts.edit', [
            'post' => $post,
            'categories' => $categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  Post  $post
     * @return Response
     */
    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);
        $post->update($this->validatePost());
        return redirect('/posts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Post  $post
     * @return Response
     * @throws Exception
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $replies = ReplyPost::where('post_id', $post->id)->get();
        foreach ($replies as $reply) {
            $reply->delete();
        }
        $post->delete();
        flash('Post удален');
        return back();
    }

    protected function imageUpload(Request $request)
    {
        $path = 'posts/'.auth()->id();
        $pathAllFiles = [];
        $allImages = $request->allFiles();
        foreach ($allImages as $image) {
            $i = count($allImages['image']) - 1;
            while (isset($image[$i])) {
                $pathImagesFull = $image[$i]->store($path, 'public');
                $pathImagesPreview = $image[$i]->store('preview/'.$path, 'public');
                Image::make($image[$i]->getRealPath())->fit(256)->save(public_path('storage/'.$pathImagesPreview), 70);
                $pathAllFiles['full'][] = $pathImagesFull;
                $pathAllFiles['preview'][] = $pathImagesPreview;
                $i--;
            }
        }
        return $pathAllFiles;
    }

    protected function validatePost()
    {
        return request()->validate([
            'category_id' => 'required|integer',
            'title' => 'required',
            'description' => 'required',
        ]);
    }

    public function linkRequest(Post $post)
    {
        Mail::to($post->owner->email)->send(new RequestLinkFromUserPost($post));
        flash("Запрос отправлен {$post->owner->name}");
        return back();
    }
}
