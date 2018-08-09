<?php

use Faker\Generator as Faker;

$factory->define(\Hedonist\Entities\User\Taste::class, function (Faker $faker) {
    return [
        'name' => $faker->word
    ];
});
