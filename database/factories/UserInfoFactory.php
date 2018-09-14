<?php

use Faker\Generator as Faker;
use Hedonist\Entities\User\User;
use Hedonist\Entities\User\UserInfo;

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

$factory->define(UserInfo::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        "first_name" => $faker->firstName,
        "last_name" => $faker->lastName,
        "date_of_birth" => $faker->date(),
        "phone_number" => $faker->phoneNumber,
        "avatar_url" => $faker->imageUrl(),
        "facebook_url" => $faker->url,
        "instagram_url" => $faker->url,
        "twitter_url" => $faker->url,
        'language' => $faker->randomElement(['en', 'ua', 'ru']),
    ];
});
