<?php

use Faker\Generator as Faker;

$factory->define(App\Town::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
    ];
});
