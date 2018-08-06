<?php

use Faker\Generator as Faker;

$factory->define(\Hedonist\Entities\User\UserTaste::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence('2')
    ];
});
