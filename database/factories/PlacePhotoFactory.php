<?php

use Faker\Generator as Faker;
use Hedonist\Entities\Place\PlacePhoto;
use Hedonist\Entities\Place\Place;
use Hedonist\Entities\User\User;

$factory->define(PlacePhoto::class, function (Faker $faker) {
    return [
        'place_id' => function () {
            return factory(Place::class)->create()->id;
        },
        'creator_id' => function () {
            return factory(User::class)->create()->id;
        },
        'img_url' => $faker->imageUrl(500, 500),
        'description' => $faker->sentence(3),
    ];
});
