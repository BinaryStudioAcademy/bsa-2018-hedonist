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
$factory->define(PlaceCategory::class, function (Faker $faker) {
    return [ 'name' => $faker->unique()->word ];
});
