<?php

use Faker\Generator as Faker;
use Hedonist\Entities\Place\PlacePhoto;
use Hedonist\Entities\Place\Place;
use Hedonist\Entities\User\User;

$factory->define(PlacePhoto::class, function (Faker $faker) {

    $width = $faker->numberBetween(200, 900);
    $height = $faker->numberBetween(200, 900);
    return [
        'place_id' => function () {
            return factory(Place::class)->create()->id;
        },
        'creator_id' => function () {
            return factory(User::class)->create()->id;
        },
        'img_url' => $faker->imageUrl($width, $height),
        'description' => $faker->sentence(3),
        'width' => $width,
        'height' => $height
    ];
});
