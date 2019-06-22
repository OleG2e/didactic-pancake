<?php

use App\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'category_id' => 1,
        'owner_id' => 1,
        'title' => 'New Post Title',
        'images' => '{"full": ["posts/1/WUqUWiM7KXiUuc4184xBjGyCfnhmdVIQPKEivNQu.jpeg", "posts/1/rXvelpW5h0HmlpSS82AarvGAXY3qNx77oDnwqYfL.jpeg"], "preview": ["preview/posts/1/WUqUWiM7KXiUuc4184xBjGyCfnhmdVIQPKEivNQu.jpeg", "preview/posts/1/rXvelpW5h0HmlpSS82AarvGAXY3qNx77oDnwqYfL.jpeg"]}',
        'description' => $faker->text,
        'relevance' => true,
    ];
});
