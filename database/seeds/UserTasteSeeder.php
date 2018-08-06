<?php

use Illuminate\Database\Seeder;
use Hedonist\Entities\User\UserTaste;

class UserTasteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserTaste::create('spicy food');
        UserTaste::create('live music');
        UserTaste::create('electronic music');
        UserTaste::create('jazz');
        UserTaste::create('vegetarian food');
        UserTaste::create('italian food');
        UserTaste::create('fast food');
        UserTaste::create('asian food');
        UserTaste::create('rolls');
        UserTaste::create('coffee');
        UserTaste::create('quite places');
        UserTaste::create('anti cafe');
        UserTaste::create('good service');
        UserTaste::create('no queues');
    }
}
