<?php

use Illuminate\Database\Seeder;
use Hedonist\Entities\Place\PlaceCategory;
use Illuminate\Support\Facades\DB;

class PlaceCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PlaceCategory::query()->insert([
            ['name' => 'Bar'],
            ['name' => 'Beer'],
            ['name' => 'Restaurant'],
            ['name' => 'Cafeteria'],
            ['name' => 'Cafe'],
            ['name' => 'Nightlife'],
            ['name' => 'Snacks'],
            ['name' => 'Other']
        ]);
    }
}