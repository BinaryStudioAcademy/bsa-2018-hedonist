<?php

use Illuminate\Database\Seeder;
use Hedonist\Entities\Place\Place;
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
        $categories = PlaceCategory::with('tags')->get();

        foreach ($places as $place) {
            $category = $categories->where('id', $place->category_id)->first();

            $tags = $category->tags->shuffle()
                ->take(
                    mt_rand(1, $category->tags->count())
                );

            $place->tags()->saveMany($tags);
        }
    }
}
