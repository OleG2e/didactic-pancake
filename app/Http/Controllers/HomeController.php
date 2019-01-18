<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function upload(Request $request)
    {
        $path = $request->file('avatar')->store('avatars' . auth()->id(), 'public');
        //$path = Storage::putFileAs('public/avatars/' . auth()->id(), $request->file('avatar'), 'avatar.jpg','public');
        return view('welcome', ['avatarPath' => $path]);
        //return view('home');
    }

    public function deleteAvatar(Request $request)
    {
        Storage::delete('file.jpg');
    }

    public function uploadFile(Request $request)
    {
        Storage::putFile('avatars', $request->file('avatar'));
    }
}
