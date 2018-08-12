<?php

use Faker\Generator as Faker;
use Hedonist\Entities\User\User;
use Hedonist\Entities\Place\Place;
use Hedonist\Entities\Dislike\Dislike;

$factory->define(Dislike::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        'dislikeable_id' => function () {
            return factory(Place::class)->create()->id;
        },
        'dislikeable_type' => Place::class
    ];
});
