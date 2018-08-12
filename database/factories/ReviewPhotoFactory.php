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
    return [
        'review_id' => function () {
            return factory(Review::class)->create()->id;
        },
        'description' => $faker->sentence(3),
        'img_url' => $faker->imageUrl()
    ];
});
