<?php

use Faker\Generator as Faker;
use Hedonist\Entities\Place\PlacesVisited;

$factory->define(PlacesVisited::class, function (Faker $faker) {
    return [

        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        'place_id' => function () {
            return factory(Place::class)->create()->id;
        },
    ];
});
