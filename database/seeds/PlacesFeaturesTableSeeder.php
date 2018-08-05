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
        PlaceFeature::query()->insert([
            'wi-fi',
            'music',
            'credit cards',
            'hookah',
            'outdoor seating',
            'wheelchair accessible',
            'reservations',
            'parking',
            'restroom',
            'take-out',
            'delivery',
            'live music'
        ]);
    }
}
