<?php

use Faker\Generator as Faker;
use Hedonist\Entities\Review\Review;
use Hedonist\Entities\User\User;
use Hedonist\Entities\Place\Place;
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

$factory->define(Review::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        'place_id' => function () {
            return factory(Place::class)->create()->id;
        },
        'description' => $faker->sentence(3),
    ];
});
