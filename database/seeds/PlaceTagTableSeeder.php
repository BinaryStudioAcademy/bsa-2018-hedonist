<?php

use Illuminate\Database\Seeder;
use Hedonist\Entities\Place\Place;
use Hedonist\Entities\Place\PlaceTag;
use Hedonist\Entities\Place\PlaceCategory;

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

            $categoryTags = PlaceCategory::find($place->category_id)
                ->tags()
                ->get()
                ->pluck('id')
                ->toArray();

            $tagsArray = array_flip(range(min($categoryTags), max($categoryTags)));

            if (count($tagsArray) <= 2) {
                $smallArrayTags = array_rand($tagsArray, 1);
                PlaceTag::create([
                    'placecategory_placetag_id' => $smallArrayTags,
                    'place_id' => $place->category_id
                ]);

            } elseif (count($tagsArray) <= 3) {
                $middleArrayTags = array_rand($tagsArray, rand(2, 3));
                for ($i = 0; $i < count($middleArrayTags); $i++) {
                    PlaceTag::create([
                        'placecategory_placetag_id' => $middleArrayTags[$i],
                        'place_id' => $place->category_id
                    ]);
                }
            } else {
                $bigArrayTags = array_rand($tagsArray, rand(3, 5));
                for ($i = 0; $i < count($bigArrayTags); $i++) {
                    PlaceTag::create([
                        'placecategory_placetag_id' => $bigArrayTags[$i],
                        'place_id' => $place->category_id
                    ]);
                }
            }

        }
    }
}
