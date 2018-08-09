<?php

use Hedonist\Entities\Place\PlaceCategory;
use Hedonist\Entities\Place\PlaceCategoryTag;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class PlaceCategoriesTagsSeeder extends Seeder
{
    const DATA = [
        'cafe' => [
            'tagsCafee1',
            'tagsCafee2',
            'tagsCafee3',
            'tagsCafeet4',
            'tagsCafee5'
        ],
        'restaurant' => [
            'tagsRestaurant1',
            'tagsRestaurant2',
            'tagsRestaurant3',
            'tagsRestaurant4',
            'tagsRestaurant5'
        ],
        'bar' => [
            'tagsBar1',
            'tagsBar2',
            'tagsBar3',
            'tagsBar4',
            'tagsBar5'
        ],
        'pub' => [
            'tagsPub1',
            'tagsPub2',
            'tagsPub3',
            'tagsPub4',
            'tagsPub5'
        ],

    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        DB::table('place_categories_tags')->truncate();

//            factory(PlaceCategoryTag::class)->create()->each(function ($tag) {
//                $tag->categories()->save(factory(PlaceCategory::class)->make());
//            });

        foreach (self::DATA as $category => $tags) {

            $placeCategoryId = PlaceCategory::create(['name' => $category])->id;

            foreach ($tags as $subTag) {
                PlaceCategoryTag::create([
                    'name' => $subTag
                ]);
            }
        }

    }
}
