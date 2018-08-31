<?php

use Faker\Generator as Faker;

$factory->define(\Hedonist\Entities\User\Taste::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'user_id' => function () {
            return factory(\Hedonist\Entities\User\User::class)->create()->id;
        },
        'is_default' => false
    ];
});
