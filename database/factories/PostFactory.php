<?php

use \App\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'category_id' => 1,
        'owner_id' => 1,
        'title' => $faker->word,
        'description' => $faker->text,
    ];
});
