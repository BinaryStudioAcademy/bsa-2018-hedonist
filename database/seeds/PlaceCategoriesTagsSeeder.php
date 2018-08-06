<?php

use Hedonist\Entities\Place\PlaceCategory;
use Hedonist\Entities\Place\PlaceCategoryTag;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class PlaceCategoriesTagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('place_categories_tags')->truncate();

        factory(PlaceCategoryTag::class, 30)->create()->each(function ($tag) {
            $tag->categories()->save(factory(PlaceCategory::class)->make());
        });
    }
}
