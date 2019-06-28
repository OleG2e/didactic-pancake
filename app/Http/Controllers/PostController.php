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

    protected function sql($id)
    {
        return Post::where('relevance', true)->where('category_id', $id)->paginate(25);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $routeName = \Request::route()->getName();
        switch ($routeName) {
            case 'post.all':
                $posts = Post::where('relevance', true)->paginate(25);
                return view('posts.index', compact('posts'));
                break;
            case 'post.buy':
                $posts = $this->sql(4);
                if (\request()->wantsJson()) {
                    return $posts;
                }
                return view('posts.index', compact('posts'));
                break;
            case 'post.sell':
                $posts = $this->sql(5);
                if (\request()->wantsJson()) {
                    return $posts;
                }
                return view('posts.index', compact('posts'));
                break;
            case 'post.help':
                $posts = $this->sql(6);
                if (\request()->wantsJson()) {
                    return $posts;
                }
                return view('posts.index', compact('posts'));
                break;
            case 'post.pet':
                $posts = $this->sql(7);
                if (\request()->wantsJson()) {
                    return $posts;
                }
                return view('posts.index', compact('posts'));
                break;
            case 'post.service':
                $posts = $this->sql(8);
                if (\request()->wantsJson()) {
                    return $posts;
                }
                return view('posts.index', compact('posts'));
                break;
            case 'post.loss':
                $posts = $this->sql(9);
                if (\request()->wantsJson()) {
                    return $posts;
                }
                return view('posts.index', compact('posts'));
                break;
            default:
                return redirect(route('home'));
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $categories = Category::where('id', '>', 3)->get();

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
        $createdPost = $post->create($attributes);
        flash('Объявление создано');

        return redirect(route('post.show', $createdPost));
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

            return view('posts.show', compact(['post', 'imagesAll']));
        }

        return view('posts.show', compact(['post']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Post  $post
     * @return Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Post $post)
    {
        $this->authorize('update', $post);

        $categories = Category::where('id', '>', 3)->get();

        return view('posts.edit', compact(['post', 'categories']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  Post  $post
     * @return Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $images = $this->imageUpload($request);
        $attributes = $this->validatePost();
        $attributes['images'] = $images;
        $post->update($attributes);
        flash('Объявление изменено');
        return redirect(route('post.show', $post->id));
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

    protected function validatePost()
    {
        return request()->validate([
            'category_id' => 'required|integer|exists:categories,id',
            'title' => 'required|string|max:20',
            'description' => 'required|string|max:1024',
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