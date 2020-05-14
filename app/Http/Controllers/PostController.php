<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Helpers\MapHelper;
use App\Http\Requests\PostRequest;
use App\Mail\RequestLinkFromUser;
use App\Point;
use App\Post;
use App\Category;
use App\Reply;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

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
            $posts = Post::whereRelevance(true)->paginate();
        } else {
            $posts = Category::where('slug', $category)->firstOrFail()->posts()->whereRelevance(true)->paginate();
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
        $images = Helpers::imageUpload();
        $attributes = $request->validated();
        $attributes['owner_id'] = auth()->id();
        $attributes['images'] = $images;

        if (!empty($attributes['coords'])) {
            $point = [];
            $coords = explode(',', $attributes['coords']);
            $point['latitude'] = $coords[0];
            $point['longitude'] = $coords[1];
            $createdPoint = Point::create($point);
            $attributes['point_id'] = $createdPoint->id;
        }

        $createdPost = $post->create($attributes);
        Helpers::flash('Объявление создано');

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
        $points = MapHelper::getPoints(collect()->push($post));

        return view('posts.show', compact(['post', 'points']));
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

        $images = Helpers::imageUpload();
        $attributes = $request->validated();
        $attributes['images'] = $images;
        if (!empty($attributes['coords'])) {
            $point = [];
            $coords = explode(',', $attributes['coords']);
            $point['latitude'] = $coords[0];
            $point['longitude'] = $coords[1];
            $updatedPoint = $post->point->update($point);
        }
        $post->update($attributes);
        Helpers::flash('Объявление изменено');
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
        $post->point()->delete();
        $post->delete();
        Helpers::flash('Объявление удалено');

        return redirect(route('my.posts'));
    }

    public function linkRequest(string $category, Post $post): RedirectResponse
    {
        $route = route('post.show', [$category, $post->id]);
        Mail::to($post->owner->email)->send(new RequestLinkFromUser($route));
        Helpers::flash("Запрос отправлен {$post->owner->username}");

        return back();
    }
}