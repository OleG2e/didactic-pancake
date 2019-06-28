<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $countCategoryPosts = Category::all()->count();
        $allPosts = collect();

        for ($i = 1; $i <= $countCategoryPosts; $i++) {
            if (Post::where('relevance', true)->where('category_id', $i)->count() > 0) {
                $allPosts->push(Post::where('relevance', true)->where('category_id', $i)->latest()->get());
            }
        }

        return view('welcome', compact('allPosts'));
    }
}
