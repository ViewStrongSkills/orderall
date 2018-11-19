<?php

use Faker\Generator as Faker;

$factory->define(App\Business::class, function (Faker $faker) {
    $faker = \Faker\Factory::create('en_AU');
    $website = $faker->domainName();
    return [
        'name' => $faker->company(),
        'phone_country_code' => '+61',
        'phone' => $faker->phoneNumber(),
        'email' => $faker->userName() . '@' . $website,
        'website' => 'http://' . $website,
        'addressLine1' => $faker->secondaryAddress(),
        'addressLine2' => $faker->buildingNumber() . ' ' . $faker->streetName(),
        'locality' => $faker->city(),
        'postcode' => random_int(0, 9999),
        'latitude' => -37.822507 + (random_int(-1000, 1000) / 10000),
        'longitude' => 145.035525 + (random_int(-1000, 1000) / 10000),
        'supports_payment' => false,
        'image_path' => 'images/businesses/5e868578070f150a71c337915797087b.png',
    ];
});
