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
        factory(PlaceCategory::class, 6)->create();
    }
}