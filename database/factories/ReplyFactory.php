<?php

use Faker\Generator as Faker;

$factory->define(
    App\Reply::class,
    function (Faker $faker) {
        return [
            'attachment' => json_encode($faker->imageUrl()),
            'description' => $faker->text,
            'model_id' => 1,
            'model_name' => \App\Post::MODEL_NAME,
            'owner_id' => 1,
        ];
    }
);
