<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Mail\RequestLinkFromUser;
use App\Post;
use App\Category;
use App\Reply;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
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
     * @param  string  $category
     * @return View
     */
    public function index(string $category): View
    {
        if ($category === 'all') {
            $posts = Post::whereRelevance(true)->paginate(25);
        } else {
            $posts = Category::where('slug', $category)->firstOrFail()->posts()->whereRelevance(true)->paginate(25);
        }

        return view('posts.index', compact(['posts', 'category']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        $categories = Category::whereSection(Post::MODEL_NAME)->get();

        return view('posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Post  $post
     * @param  PostRequest  $request
     * @return RedirectResponse
     */
    public function store(Post $post, PostRequest $request): RedirectResponse
    {
        $images = $this->imageUpload($request);
        $attributes = $request->validated();
        $attributes['owner_id'] = auth()->id();
        $attributes['images'] = $images;
        $createdPost = $post->create($attributes);
        flash('Объявление создано');

        return redirect(route('post.show', [$createdPost->category->slug, $createdPost]));
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $category
     * @param  Post  $post
     * @return View
     */
    public function show(string $category, Post $post): View
    {
        if (isset($post->images)) {
            $imagesAll = json_decode($post->images);

            return view('posts.show', compact(['post', 'imagesAll']));
        }

        return view('posts.show', compact(['post']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $category
     * @param  Post  $post
     * @return View
     * @throws AuthorizationException
     */
    public function edit(string $category, Post $post): View
    {
        $this->authorize('update', $post);

        $categories = Category::whereSection(Post::MODEL_NAME)->get();

        return view('posts.edit', compact(['post', 'categories']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  string  $category
     * @param  Post  $post
     * @param  PostRequest  $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(string $category, Post $post, PostRequest $request): RedirectResponse
    {
        $this->authorize('update', $post);

        $images = $this->imageUpload($request);
        $attributes = $request->validated();
        $attributes['images'] = $images;
        $post->update($attributes);
        flash('Объявление изменено');
        return redirect(route('post.show', [$category, $post->id]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $category
     * @param  Post  $post
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(string $category, Post $post): RedirectResponse
    {
        $this->authorize('delete', $post);

        $replies = Reply::where('model_id', $post->id)->where('model_name', Post::MODEL_NAME)->get();
        foreach ($replies as $reply) {
            $reply->delete();
        }
        $post->delete();
        flash('Объявление удалено');

        return redirect(route('my.posts'));
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
                $pathAllFiles['full'][] = $pathImagesFull;//in production use 'public/'.$pathImagesFull
                $pathAllFiles['preview'][] = $pathImagesPreview;//in production use 'public/'.$pathImagesPreview
                $i--;
            }
        }

        return json_encode($pathAllFiles);
    }

    public function linkRequest(string $category, Post $post): RedirectResponse
    {
        $route = route('post.show', [$category, $post->id]);
        Mail::to($post->owner->email)->send(new RequestLinkFromUser($route));
        flash("Запрос отправлен {$post->owner->name}");

        return back();
    }
}