<?php

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
        DB::table('places_features')->delete();
        factory(\Hedonist\Entities\Place\PlaceFeature::class, 12)->create();
    }
}
