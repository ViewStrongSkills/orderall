<?php

use Faker\Generator as Faker;

$factory->define(App\Menu::class, function (Faker $faker) {
    return [
        'name' => 'Main',
        'main' => true,
    ];
});

$factory->define(App\Menu::class, function (Faker $faker) {
    return [
        'name' => $faker->word(),
        'main' => false,
    ];
});
