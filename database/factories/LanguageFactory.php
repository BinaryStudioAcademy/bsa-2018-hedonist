<?php

use Faker\Generator as Faker;

use Hedonist\Entities\Localization\Language;

$factory->define(Language::class, function (Faker $faker) {
    return [
        'code' => $faker->languageCode,
        'active' => $faker->boolean,
        'default' => false,
    ];
});
