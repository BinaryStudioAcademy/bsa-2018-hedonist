<?php

use Faker\Generator as Faker;
use Hedonist\Entities\Place\City;

$factory->define(City::class, function (Faker $faker) {
    return [
        'name' => $faker->city,
    ];
});
