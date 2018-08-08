<?php

use Faker\Generator as Faker;
use Hedonist\Entities\Place\Checkin;
use Hedonist\Entities\User\User;
use Hedonist\Entities\Place\Place;

$factory->define(Checkin::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        'place_id' => function () {
            return factory(Place::class)->create()->id;
        },
    ];
});
