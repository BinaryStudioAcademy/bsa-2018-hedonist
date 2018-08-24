<?php

use Illuminate\Database\Seeder;
use Hedonist\Entities\User\User;
use Hedonist\Entities\UserList\UserList;
use Hedonist\Entities\Place\Place;
use Hedonist\Entities\Place\City;
use Faker\Factory as Faker;

class UserListTableSeeder extends Seeder
{
    const LISTS = [
        [
            'name' => 'Favorite Lviv cafes',
            'img_url' => 'https://therantingpanda.files.wordpress.com/2016/03/img_9130e.jpg',
            'city' => 'Lviv'
        ], [
            'name' => 'Favourite Lviv restaurants',
            'img_url' => 'https://www.adelaidereview.com.au/content/uploads/2018/03/restaurant-review-lantern-by-nu-adelaide-review-5-800x566.jpg',
            'city' => 'Lviv'
        ], [
            'name' => 'Favourite Lviv hookah bars',
            'img_url' => 'https://media-cdn.tripadvisor.com/media/photo-s/07/6f/52/2e/fiction-nightclub.jpg',
            'city' => 'Lviv'
        ], [
            'name' => 'Favorite Ukraine cafes',
            'img_url' => 'https://therantingpanda.files.wordpress.com/2016/03/img_9130e.jpg',
            'city' => null
        ], [
            'name' => 'Favourite Ukraine restaurants',
            'img_url' => 'https://www.adelaidereview.com.au/content/uploads/2018/03/restaurant-review-lantern-by-nu-adelaide-review-5-800x566.jpg',
            'city' => null
        ], [
            'name' => 'Favourite Ukraine restaurants with hookah',
            'img_url' => 'http://www.terracerestaurantandlounge.com/wp-content/uploads/2013/10/hooka-400x270.jpg',
            'city' => null
        ], [
            'name' => 'Favourite Ukraine seafood restaurants',
            'img_url' => 'http://www.baybreezeseafood.com/images/flash-5.jpg',
            'city' => null
        ], [
            'name' => 'Favourite Kiev open air restaurants',
            'img_url' => 'https://media-cdn.tripadvisor.com/media/photo-s/07/6f/52/2e/fiction-nightclub.jpg',
            'city' => 'Kiev'
        ]
    ];

    public function run(): void
    {
        $faker = Faker::create();
        $users = User::all();
        foreach ($users as $user) {
            foreach (self::LISTS as $list) {
                $userList = UserList::create([
                    'user_id' => $user->id,
                    'name' => $list['name'],
                    'img_url' => $list['img_url'],
                ]);

                $cityId = $list['city'] ? City::where('name', $list['city'])->pluck('id')->first() : null;
                $placeQuantity = $faker->randomFloat(0, 10, 20);
                $places = $cityId ?
                    Place::where('city_id', $cityId)->inRandomOrder()->take($placeQuantity)->get() :
                    Place::inRandomOrder()->take($placeQuantity)->get();
                $userList->places()->attach($places->pluck('id')->all());
            }
        }
    }
}
