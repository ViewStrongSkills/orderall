<?php

use Faker\Generator as Faker;

$factory->define(App\MenuItem::class, function (Faker $faker) {
    return [
        'price' => $faker->numberBetween(10, 20),
        'discount' => $faker->numberBetween(1, 10),
        'name' => $faker->word(),
        'description' => $faker->paragraph(),
        'category' => 'test-cat',
        'image_path' => '739aaf363bbfa91612f09ac9cee380e0',
    ];
});
