<?php

use Faker\Generator as Faker;
use Hedonist\Entities\UserList\UserList;
use Hedonist\User;

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

$factory->define(UserList::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        'name' => $faker->cityPrefix,
        'img_url' => $faker->imageUrl()
    ];
});
