<?php

use Illuminate\Database\Seeder;
use Hedonist\Entities\User\Taste;

class UserTasteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Taste::create('spicy food');
        Taste::create('vegetarian food');
        Taste::create('italian food');
        Taste::create('fast food');
        Taste::create('asian food');
        Taste::create('rolls');
        Taste::create('coffee');
        Taste::create('quite places');
        Taste::create('anti cafe');
        Taste::create('good service');
        Taste::create('no queues');
    }
}
