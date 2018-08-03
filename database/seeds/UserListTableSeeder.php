<?php

use Illuminate\Database\Seeder;
use Hedonist\Entities\UserList\UserList;

class UserListTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(UserList::class,3)->create();
    }
}
