<?php

use Faker\Generator as Faker;
use Hedonist\Entities\Place\PlaceCategory;

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
$factory->define(\Hedonist\Entities\Place\FavouritePlace::class, function (Faker $faker) use ($factory) {
    return [
        'user_id' => $factory->create(\Hedonist\User::class)->id,
        'place_id' => $factory->create(\Hedonist\Entities\Place\Place::class)->id
    ];
});
