<?php

use Faker\Generator as Faker;

$factory->define(App\MenuExtra::class, function (Faker $faker) {
    return [
        'name' => $faker->word(),
        'price' => mt_rand(0, 2),
    ];
});
