<?php

use Faker\Generator as Faker;
use Hedonist\Entities\Place\PlaceTaste;
use Hedonist\Entities\Place\Place;
use Hedonist\Entities\User\Taste;

$factory->define(PlaceTaste::class, function (Faker $faker) use ($factory) {
    return [
        'place_id' => $factory->create(Place::class)->id,
        'taste_id' => $factory->create(Taste::class)->id
    ];
});