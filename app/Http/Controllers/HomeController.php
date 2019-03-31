<?php

namespace App\Http\Controllers;

use App\Post;
use App\Trip;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        $user = Auth::user();

        return view('/home/main', compact('user'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $user->about = (string)$request['about'];
        if ($request['phone']) {
            $user->phone = (integer)$request['phone'];
        } elseif ($request['phone'] == false) {
            $user->phone = null;
        }
        $user->save();
        return back();
    }

    public function myPosts(Post $post)
    {
        $myPosts = Post::where('owner_id', auth()->id())->latest()->get();

        return view('/home/my_posts', compact('myPosts'));
    }

    public function updateRelevancePost(Post $post, Request $request)
    {
        $post->update([
            'updated_at' => time(),
            'relevance' => $request->has('relevance'),
        ]);
        return back();
    }

    public function updateRelevanceTrip(Trip $trip, Request $request)
    {
        $trip->update([
            'updated_at' => time(),
            'relevance' => $request->has('relevance'),
        ]);
        return back();
    }

    public function updateRelevanceEntry(Entry $entry, Request $request)
    {
        $entry->update([
            'updated_at' => time(),
            'relevance' => $request->has('relevance'),
        ]);
        return back();
    }

    /**
     * Update the avatar for the user.
     *
     * @param Request $request
     * @return Response
     */
    public function updateAvatar(Request $request)
    {
        $path = $request->file('avatar')->storeAs('avatars/' . auth()->id(), 'avatar.jpg', 'public');
        Image::make(url($path))->resize(512, 512)->save('storage/' . $path);
        return back();
    }

    public function myTrips(Trip $trip)
    {
        $myTrips = Trip::where('owner_id', auth()->id())->latest()->get();
        return view('/home/my_trips', compact('myTrips'));
    }

    public function myEntries(Entry $entry)
    {
        $myEntries = Entry::where('owner_id', auth()->id())->latest()->get();
        return view('/home/my_entries', compact('myEntries'));
    }
}