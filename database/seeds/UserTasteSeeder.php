<?php

use Illuminate\Database\Seeder;
use Hedonist\Entities\User\Taste;

class UserTasteSeeder extends Seeder
{
    const TASTES = [
        'spicy food',
        'vegetarian food',
        'italian food',
        'fast food',
        'asian food',
        'rolls',
        'coffee',
        'quite places',
        'anti cafe',
        'good service',
        'no queues'
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (self::TASTES as $taste) {
            Taste::create([
                'name' => $taste
            ]);
        }
    }
}
