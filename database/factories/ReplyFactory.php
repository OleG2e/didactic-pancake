<?php

use Faker\Generator as Faker;

$factory->define(App\Reply::class, function (Faker $faker) {
    return [
        'owner_id' => 1,
        'post_id' => 1,
        'category_id' => 1,
        'description' => $faker->text,
    ];
});
