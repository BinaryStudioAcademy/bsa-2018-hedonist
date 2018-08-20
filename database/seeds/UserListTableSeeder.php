<?php

use Illuminate\Database\Seeder;
use Hedonist\Entities\User\User;
use Hedonist\Entities\UserList\UserList;
use Hedonist\Entities\Place\Place;

class UserListTableSeeder extends Seeder
{
    const LISTS  = [
        [
            'name'=>'Favorite Lviv cafes',
            'img_url'=> 'https://therantingpanda.files.wordpress.com/2016/03/img_9130e.jpg'
        ],[
            'name'=>'Favourite Lviv restaurants',
            'img_url'=> 'https://www.adelaidereview.com.au/content/uploads/2018/03/restaurant-review-lantern-by-nu-adelaide-review-5-800x566.jpg'
        ],[
            'name'=>'Favourite Lviv night club',
            'img_url'=> 'https://media-cdn.tripadvisor.com/media/photo-s/07/6f/52/2e/fiction-nightclub.jpg'
        ],[
            'name'=>'Favorite Ukraine cafes',
            'img_url'=> 'https://therantingpanda.files.wordpress.com/2016/03/img_9130e.jpg'
        ],[
            'name'=>'Favourite Ukraine restaurants',
            'img_url'=> 'https://www.adelaidereview.com.au/content/uploads/2018/03/restaurant-review-lantern-by-nu-adelaide-review-5-800x566.jpg'
        ],[
            'name'=>'Favourite Kiev night club',
            'img_url'=> 'https://media-cdn.tripadvisor.com/media/photo-s/07/6f/52/2e/fiction-nightclub.jpg'
        ]
    ];

    public function run() : void
    {
        $users = User::all();
        foreach ($users as $user) {

            foreach (self::LISTS as $list){
                $userList = UserList::create([
                    'user_id' => $user->id,
                    'name' => $list['name'],
                    'img_url' => $list['img_url'],
                ]);
                $userList->places()->attach(Place::inRandomOrder()->first()->id);
                $userList->places()->attach(Place::inRandomOrder()->first()->id);
                $userList->places()->attach(Place::inRandomOrder()->first()->id);
                $userList->places()->attach(Place::inRandomOrder()->first()->id);
                $userList->places()->attach(Place::inRandomOrder()->first()->id);
                $userList->places()->attach(Place::inRandomOrder()->first()->id);
                $userList->places()->attach(Place::inRandomOrder()->first()->id);
                $userList->places()->attach(Place::inRandomOrder()->first()->id);
            }
        }
    }
}
