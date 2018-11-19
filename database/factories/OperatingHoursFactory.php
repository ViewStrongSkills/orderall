<?php

use Faker\Generator as Faker;

$factory->define(App\OperatingHour::class, function (Faker $faker) {
    return [
        'opening_time' => $faker->time($format = 'H:i:s', $max = '10:00:00'),
        'closing_time' => $faker->time($format = 'H:i:s', $min = '10:00:01'),
        'day' => $faker->unique()->numberBetween(1, 7),
        'entry_type' => 'App\Business',
    ];
});
