<?php

namespace App\Http\Controllers;

use App\Mail\RequestLinkFromUser;
use App\Post;
use App\Category;
use App\Reply;
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
        $posts = Post::where('relevance', true)->paginate(25);

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
        $images = $this->imageUpload($request);
        $attributes = $this->validatePost();
        $attributes['owner_id'] = auth()->id();
        $attributes['images'] = $images;
        $post->create($attributes);
        flash('Объявление создано');

        return redirect('/posts');
    }

    /**
     * Display the specified resource.
     *
     * @param  Post  $post
     * @return Response
     */
    public function show(Post $post)
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

        $images = $this->imageUpload($request);
        $attributes = $this->validatePost();
        $attributes['images'] = $images;
        $post->update($attributes);
        flash('Объявление изменено');

        return redirect(route('post.show', $post));
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

        $replies = Reply::where('post_id', $post->id)->get();
        foreach ($replies as $reply) {
            $reply->delete();
        }
        $post->delete();
        flash('Объявление удалено');

        return redirect(route('post.all'));
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

        return json_encode($pathAllFiles);
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
        $route = route('post.show', ['posts' => $post->id]);
        Mail::to($post->owner->email)->send(new RequestLinkFromUser($route));
        flash("Запрос отправлен {$post->owner->name}");

        return back();
    }
}
