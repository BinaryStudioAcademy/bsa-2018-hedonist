<?php

use Faker\Generator as Faker;
use Hedonist\Entities\Place\{
    PlaceRating,
    Place
};
use Hedonist\Entities\User\User;

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
            return User::inRandomOrder()->first()->id;
        },

        'place_id' => function () {
            return Place::inRandomOrder()->first()->id;
        },

        'rating' => $faker->biasedNumberBetween(1, 10)
    ];
});
