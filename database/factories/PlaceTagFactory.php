<?php

use Faker\Generator as Faker;
use Hedonist\Entities\Place\Place;
use Hedonist\Entities\Place\PlaceTag;
use Hedonist\Entities\Place\Tag;

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
$factory->define(PlaceTag::class, function (Faker $faker) use ($factory) {
    return [
        'placecategory_placetag_id' => $factory->create(Tag::class)->id,
        'place_id' => $factory->create(Place::class)->id
    ];
});
