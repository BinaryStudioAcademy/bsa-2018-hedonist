<?php

use Faker\Generator as Faker;
use Hedonist\Entities\Place\Tag;

$factory->define(Tag::class, function (Faker $faker) {
    $tags = [
        'asian cuisine',
        'authentic',
        'beer',
        'casual',
        'chicken',
        'cocktails',
        'cozy',
        'crowded',
        'european cuisine',
        'french cuisine',
        'fresh fruit juice',
        'good for dates',
        'good for groups',
        'good for singles',
        'healthy food',
        'homemade food',
        'inexpensive',
        'italian cuisine',
        'lobster',
        'octopus',
        'pasta',
        'pizza',
        'romantic',
        'seafood',
        'spicy food',
        'steak',
        'sushi',
        'ukrainian cuisine',
        'vegetatian food',
        'wine',
    ];
    
    return [
        'name' => $faker->unique()->randomElement($tags)
    ];
});
