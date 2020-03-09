<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppTemplate extends Model
{
    public static function countMyAds(): array
    {
        $user = auth()->user();
        $myTrips = $user->trips()->count();
        $myPosts = $user->posts()->count();
        $myDeliveries = $user->deliveries()->count();

        return compact(['myTrips', 'myPosts', 'myDeliveries']);
    }

    public static function currentCategory(): string
    {
        return \Request::route()->parameter('category');
    }

    public static function countAds(): array
    {
        $trips = Category::where('slug', 'trip')->firstOrFail()->trips()->whereRelevance(true)->count();
        $deliveries = Category::where('slug', 'delivery')->firstOrFail()->trips()->whereRelevance(true)->count();
        $all = Post::whereRelevance(true)->count();
        $buys = Category::where('slug', 'buy')->firstOrFail()->posts()->whereRelevance(true)->count();
        $sells = Category::where('slug', 'sell')->firstOrFail()->posts()->whereRelevance(true)->count();
        $helps = Category::where('slug', 'help')->firstOrFail()->posts()->whereRelevance(true)->count();
        $pets = Category::where('slug', 'pet')->firstOrFail()->posts()->whereRelevance(true)->count();
        $services = Category::where('slug', 'service')->firstOrFail()->posts()->whereRelevance(true)->count();
        $losses = Category::where('slug', 'loss')->firstOrFail()->posts()->whereRelevance(true)->count();

        return compact(
            [
                'all',
                'trips',
                'deliveries',
                'buys',
                'sells',
                'helps',
                'pets',
                'services',
                'losses'
            ]
        );
    }
}
