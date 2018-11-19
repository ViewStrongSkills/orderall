<?php

use Faker\Generator as Faker;

$factory->define(App\MenuExtraCategory::class, function (Faker $faker) {
    return [
        'name' => $faker->word(),
        'required' => $faker->boolean(),
    ];
});
