<?php

use Hedonist\Entities\Place\PlaceFeature;
use Illuminate\Database\Seeder;

class PlacesFeaturesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\Hedonist\Entities\Place\PlaceFeature::class, 12)->create();
    }
}
