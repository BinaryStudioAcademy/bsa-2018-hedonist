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

        foreach (self::DATA as $category => $tags) {

            foreach ($tags as $tag1) {
                $placeTagArray[] = $tag1;
            }

            for ($i = 0; $i < count($placeTagArray); $i++) {
               $placesTagsArray[] = PlaceCategoryTag::create(
                    ['name' => $placeTagArray[$i]]
                );
            }

            PlaceCategory::create(['name' => $category])
                    ->tags()
                    ->saveMany(
                        $placesTagsArray
                    );

            $placesTagsArray = [];
            $placeTagArray = [];

        }
    }
}
