<?php

namespace App\Http\Controllers;

use App\CategoryPost;
use App\Post;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $categoryPosts = CategoryPost::all();
        $allPosts = [];

        for ($i = 1; $i <= count($categoryPosts); $i++) {
            $allPosts[] = Post::where('relevance', true)->where('category_id', $i)->latest()->get();
        }

        return view('welcome', compact('allPosts'));
    }
}
