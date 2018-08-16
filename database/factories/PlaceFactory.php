<?php

use Faker\Generator as Faker;
use Hedonist\Entities\User\User;
use Hedonist\Entities\Place\City;
use Hedonist\Entities\Place\Place;
use Hedonist\Entities\Place\PlaceCategory;

$factory->define(Place::class, function (Faker $faker) {
    return [
        'longitude' => $faker->randomFloat(4, -180, 180),
        'latitude' => $faker->randomFloat(4, -90, 90),
        'zip' => $faker->numberBetween(10000, 99999),
        'address' => $faker->address,
        'phone' => $faker->phoneNumber,
        'website' => $faker->domainName,
        'creator_id' => function () {
            return factory(User::class)->create()->id;
        },
        'category_id' => function () {
            return factory(PlaceCategory::class)->create()->id;
        },
        'city_id' => function () {
            return factory(City::class)->create()->id;
        },
    ];
});

const radius = 0.003;

$factory->defineAs(Place::class, 'LvivPlaces', function (Faker $faker) {
    return [
        'longitude'     => $faker->unique()->randomFloat(6, 24.0297-radius, 24.0297+radius),
        'latitude'      => $faker->unique()->randomFloat(6, 49.8397-radius, 49.8397+radius),
        'zip'           => $faker->numberBetween(10000, 99999),
        'address'       => $faker->address,
        'phone'         => $faker->phoneNumber,
        'website'       => $faker->domainName,
        'creator_id'    => function () {
            return factory(User::class)->create()->id;
        },
        'category_id' => function () {
            return factory(PlaceCategory::class)->create()->id;
        },
        'city_id' => function () {
            return factory(City::class)->create()->id;
        },
    ];
});