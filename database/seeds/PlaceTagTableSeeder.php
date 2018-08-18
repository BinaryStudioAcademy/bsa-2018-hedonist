<?php

use Illuminate\Database\Seeder;
use Hedonist\Entities\Place\Place;
use Hedonist\Entities\Place\PlaceTag;
use Illuminate\Support\Facades\DB;

class PlaceTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $places = Place::all();

        foreach ($places as $place) {
            $getTagId = DB::table('place_category_place_tag')
                ->where('place_category_id', $place->category_id)
                ->pluck('place_tag_id')
                ->toArray();

            PlaceTag::create([
                'placecategory_placetag_id' => array_random($getTagId),
                'place_id' => $place->category_id
            ]);
        }
    }
}
