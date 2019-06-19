<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppTemplate extends Model
{
    public static function countMyAds()
    {
        $user = auth()->user();
        $myTrips = $user->trips()->count();
        $myPosts = $user->posts()->count();
        $myDeliveries = $user->deliveries()->count();

        return compact(['myTrips', 'myPosts', 'myDeliveries']);
    }

    public static function countAds()
    {
        $trips = Trip::where('category_id', 2)->whereRelevance(true)->count();
        $deliveries = Trip::where('category_id', 3)->whereRelevance(true)->count();
        $buys = Post::where('category_id', 4)->whereRelevance(true)->count();
        $sells = Post::where('category_id', 5)->whereRelevance(true)->count();
        $helps = Post::where('category_id', 6)->whereRelevance(true)->count();
        $pets = Post::where('category_id', 7)->whereRelevance(true)->count();
        $services = Post::where('category_id', 8)->whereRelevance(true)->count();
        $losses = Post::where('category_id', 9)->whereRelevance(true)->count();

        return compact([
            'trips',
            'deliveries',
            'buys',
            'sells',
            'helps',
            'pets',
            'services',
            'losses'
        ]);
    }
}
