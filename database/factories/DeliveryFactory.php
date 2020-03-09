<?php

use Faker\Generator as Faker;

$factory->define(App\Delivery::class, function (Faker $faker) {
    return [
        'category_id' => 2,
        'owner_id' => 1,
        'startpoint_id' => 1,
        'endpoint_id' => 1,
        'timestamp' => $faker->date(),
        'description' => $faker->text,
        'price' => $faker->word,
    ];
});
