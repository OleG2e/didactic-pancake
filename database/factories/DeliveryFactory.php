<?php

use Faker\Generator as Faker;

$factory->define(
    App\Delivery::class,
    function (Faker $faker) {
        return [
            'owner_id' => 1,
            'startpoint_id' => 1,
            'endpoint_id' => 1,
            'date_time' => $faker->dateTimeInInterval('now', '+10 days'),
            'description' => $faker->text,
        ];
    }
);
