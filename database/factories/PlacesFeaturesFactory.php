<?php

use Faker\Generator as Faker;
use Hedonist\Entities\Place\PlaceFeature;

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
$factory->define(PlaceFeature::class, function (Faker $faker) {
 
    $array = [
            'wi-fi',
            'music',
            'credit cards',
            'hookah',
            'outdoor seating',
            'wheelchair accessible',
            'reservations',
            'parking',
            'restroom',
            'take-out',
            'delivery',
            'live music'
    ];

    return [
        'name' => $faker->unique()->randomElement($array)
    ];
});
