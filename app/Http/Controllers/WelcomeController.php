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

        $categoriesPosts = Category::whereSection(Post::MODEL_NAME)->with('posts')->get();
        $categoriesPosts->each(
            function ($category) use ($posts) {
                if ($category->posts->isNotEmpty()) {
                    $posts->push($category->posts);
                }
            }
        );
        $points = MapHelper::getPoints($posts);

        return view('welcome', compact(['posts', 'points']));
    }
}
