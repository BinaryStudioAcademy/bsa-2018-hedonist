<?php

use Faker\Generator as Faker;
use Hedonist\Entities\Place\{PlaceRating,Place};
use Hedonist\User;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/
$factory->define(PlaceRating::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        'place_id' => function () {
            return factory(Place::class)->create()->id;
        },
        'rating' => $faker->randomFloat(1,0,10)
    ];
});
