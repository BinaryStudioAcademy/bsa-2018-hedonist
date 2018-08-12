<?php

use Faker\Generator as Faker;
use Hedonist\Entities\Place\Place;
use Hedonist\Entities\Localization\Language;
use Hedonist\Entities\Localization\PlaceTranslation;

$factory->define(PlaceTranslation::class, function (Faker $faker) {
    return [
        'place_name' => $faker->word,
        'place_description' => $faker->text,
        'place_id' => function () {
            return factory(Place::class)->create()->id;
        },
        'language_id' => function () {
            return factory(Language::class)->create()->id;
        },
    ];
});
