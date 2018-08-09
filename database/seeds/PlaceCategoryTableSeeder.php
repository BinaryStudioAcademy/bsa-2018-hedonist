<?php

use Illuminate\Database\Seeder;
use Hedonist\Entities\Place\PlaceCategory;


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
            ['name' => 'cafe'],
            ['name' => 'restaurant'],
            ['name' => 'lunch'],
            ['name' => 'bar'],
            ['name' => 'coffee'],
            ['name' => 'pizzeria'],
        ]);
    }
}