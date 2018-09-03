<?php

use Faker\Generator as Faker;
use Hedonist\Entities\Place\Place;
use Hedonist\Entities\Place\PlaceInfo;

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

$factory->define(PlaceInfo::class, function (Faker $faker) {
    return [
        'place_id' => function () {
            return factory(Place::class)->create()->id;
        },
        "work_weekend" => $faker->boolean,
        "facebook" => $faker->url,
        "instagram" => $faker->url,
        "twitter" => $faker->url
    ];
});
