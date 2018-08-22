<?php

use Illuminate\Database\Seeder;
use Hedonist\Entities\Place\Place;
use Hedonist\Entities\Place\PlaceFeature;

class PlacesAttachFeaturesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $places = Place::all();
        $features = PlaceFeature::all();

        foreach ($places as $place) {
            $countOfFeatures = rand(3, count($features));
            $place->features()->saveMany($features->random($countOfFeatures));
        }
    }
}
