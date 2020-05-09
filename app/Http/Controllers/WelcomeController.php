<?php

namespace App\Http\Controllers;

use App\Category;
use App\Helpers\MapHelper;
use App\Post;
use Illuminate\View\View;

class WelcomeController extends Controller
{
    public function index(): View
    {
        $posts = collect();

        $categoriesPosts = Category::whereSection(Post::MODEL_NAME)->get();
        $categoriesPosts->each(
            function ($category) use ($posts) {
                $posts->push($category->posts()->get());
            }
        );
        $points = MapHelper::getPoints($posts);

        return view('welcome', compact(['posts', 'points']));
    }
}
