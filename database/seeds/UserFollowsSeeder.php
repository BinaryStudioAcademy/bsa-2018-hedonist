<?php

use Illuminate\Database\Seeder;
use Hedonist\Entities\User\User;

class UserFollowsSeeder extends Seeder
{
    public function run()
    {
        User::all()->foreach(function(User $item){
            $item->followers()->attach( User::all()->random());
        });
    }
}