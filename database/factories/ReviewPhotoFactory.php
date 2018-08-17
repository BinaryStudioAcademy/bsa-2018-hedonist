<?php

use Faker\Generator as Faker;
use Hedonist\Entities\Review\ReviewPhoto;
use Hedonist\Entities\Review\Review;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(ReviewPhoto::class, function (Faker $faker) {

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
        'review_id' => function () {
            return factory(Review::class)->create()->id;
        },
        'description' => $faker->sentence(3),
        'img_url' => $faker->randomElement($photos),
        'width' => $dimension,
        'height' => $dimension,
    ];
});
