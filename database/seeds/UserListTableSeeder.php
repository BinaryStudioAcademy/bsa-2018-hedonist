<?php

use Illuminate\Database\Seeder;
use Hedonist\Entities\User\User;
use Hedonist\Entities\UserList\UserList;

class UserListTableSeeder extends Seeder
{
    const LISTS  = ['Favorite Lviv cafes','Favourite Lviv restaurants','Favourite Lviv night club'];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = factory(User::class, 3)->create();
        foreach ($users as $user) {
            UserList::create(['user_id' => $user->id,'name' => 'Favorite Lviv cafes','img_url' => 'https://therantingpanda.files.wordpress.com/2016/03/img_9130e.jpg']);
            UserList::create(['user_id' => $user->id,'name' => 'Favourite Lviv restaurants','img_url' => 'https://www.adelaidereview.com.au/content/uploads/2018/03/restaurant-review-lantern-by-nu-adelaide-review-5-800x566.jpg']);
            UserList::create(['user_id' => $user->id,'name' => 'Favourite Lviv night club','img_url' => 'https://media-cdn.tripadvisor.com/media/photo-s/07/6f/52/2e/fiction-nightclub.jpg']);
        }
    }
}
