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
                $categoryPosts = $category->posts()->get();
                if ($categoryPosts->isNotEmpty()){
                    $posts->push($categoryPosts);
                }
            }
        );
        $points = MapHelper::getPoints($posts);

        return view('welcome', compact(['posts', 'points']));
    }
}
