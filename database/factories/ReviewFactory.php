<?php

use Faker\Generator as Faker;
use Hedonist\Entities\User\User;
use Hedonist\Entities\Place\Place;
use Hedonist\Entities\Review\Review;

$factory->define(Review::class, function (Faker $faker) {

    $photos = [
        'https://goo.gl/Ch8Ke9',
        'https://goo.gl/x3AmSY',
        'https://goo.gl/WfviVp',
        'https://goo.gl/QwdfPG',
        'https://goo.gl/TAVDcL',
        'https://goo.gl/f7zX7n',
        'https://goo.gl/LYwf2U',
        'https://goo.gl/mjRgka',
        'https://goo.gl/jbeku1',
        'https://goo.gl/K6Zjgc',
        'https://goo.gl/5KJYTS'
    ];

    $dimension = $faker->numberBetween(200, 900);

    return [
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        'place_id' => function () {
            return factory(Place::class)->create()->id;
        },
        'description' => $faker->realText(),
        'img_url' => $faker->randomElement($photos),
        'width' => $dimension,
        'height' => $dimension,
    ];
});
