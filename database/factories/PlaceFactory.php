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
