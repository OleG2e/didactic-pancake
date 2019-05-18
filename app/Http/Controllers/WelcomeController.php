<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $categoryPosts = Category::all();
        $allPosts = [];

        for ($i = 1; $i <= count($categoryPosts); $i++) {
            $allPosts[] = Post::where('relevance', true)->where('category_id', $i)->latest()->get();
        }

        return view('welcome', compact('allPosts'));
    }
}
