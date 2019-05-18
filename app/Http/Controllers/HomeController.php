<?php

namespace App\Http\Controllers;

use App\Mail\FeedbackFromUser;
use App\Post;
use App\Trip;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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
        return view('home.main', compact('user'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $user->link = (string) $request['link'];
        $user->save();
        return back();
    }

    public function myPosts()
    {
        $myPosts = Post::where('owner_id', auth()->id())->latest()->get();

        return view('home.my_posts', compact('myPosts'));
    }

    public function updateRelevancePost(Post $post, Request $request)
    {
        $post->update([
            'relevance' => $request->has('relevance'),
        ]);
        return back();
    }

    public function updateRelevanceTrip(Trip $trip, Request $request)
    {
        $trip->update([
            'relevance' => $request->has('relevance'),
        ]);
        return back();
    }

    public function updateRelevanceDelivery(Trip $trip, Request $request)
    {
        $trip->update([
            'relevance' => $request->has('relevance'),
        ]);
        return back();
    }

    /**
     * Update the avatar for the user.
     *
     * @param  Request  $request
     * @return Response
     */
    public function updateAvatar(Request $request)
    {
        $path = $request->file('avatar')->storeAs('avatars/'.auth()->id(), 'avatar.jpg', 'public');
        Image::make(url($path))->fit(512)->save('storage/'.$path);
        return back();
    }

    public function myTrips()
    {
        $user = auth()->user();
        $myTrips = $user->trips;

        return view('home.my_trips', compact('myTrips'));
    }

    public function myDeliveries()
    {
        $myDeliveries = Trip::where('owner_id', auth()->id())->where('category_id', 3)->latest()->get();
        return view('home.my_deliveries', compact('myDeliveries'));
    }

    public function feedbackForm()
    {
        return view('home.feedback');
    }

    public function feedbackSubmit(Request $request)
    {
        $message = (string) $request['message'];
        Mail::to(env('ADMIN_MAIL'))->send(new FeedbackFromUser($message));
        flash('Твоё сообщение было отправлено админу');

        return back();
    }
}