<?php

use Faker\Generator as Faker;

$factory->define(
    App\Reply::class,
    function (Faker $faker) {
        return [
            'attachment' => $faker->imageUrl(),
            'description' => $faker->text,
            'model_id' => 1,
            'model_name' => $faker->word,
            'owner_id' => 1,
        ];
    }
);
