<?php

use Faker\Generator as Faker;
use Hedonist\Entities\Place\{
    PlaceRating,
    Place
};
use Hedonist\Entities\User\User;

$factory->define(PlaceRating::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },

        'place_id' => function () {
            return factory(Place::class)->create()->id;
        },

        'rating' => $faker->biasedNumberBetween(1, 5)
    ];
});
