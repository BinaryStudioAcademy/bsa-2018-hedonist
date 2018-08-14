<?php

use Hedonist\Entities\Place\PlaceCategory;
use Hedonist\Entities\Place\PlaceCategoryTag;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class PlaceCategoriesAttachTagsSeeder extends Seeder
{
    const DATA = [
        'Cafe' => [
            'Ice-cream cafe',
            'Cafe-confectionery',
            'Children\'s cafe',
            'Family cafe',
            'Internet cafe',
            'Youth cafe',
        ],
        'Cafeteria' => [
            'Coffee Room',
            'Tea Room',
        ],
        'Beer' => [
            'Brewery',
            'Kneipp',
            'Gastropub',
            'Pub',
            'Irish Pub',
            'Beer pub',
        ],
        'Restaurant' => [
            'Pizzeria',
            'Food Court',
            'Italian restaurant',
            'Vegan Restaurant',
            'European restaurant',
            'West-Ukrainian Restaurant',
            'French Restaurant',
            'Ukrainian Restaurant',
            'Asian Restaurant',
            'Vietnamese Restaurant',
            'Steak House',
        ],
        'Bar' => [
            'Lounge bar',
            'Milk bar',
            'Video Bar',
            'Cocktail bar',
            'Karaoke bar',
            'Sports bar',
            'Whiskey bar',
            'Wine bar',
            'Sushi Bar',
            'Piano Bar',
        ],
        'Nightlife' => [
            'Hookah',
            'Strip club',
            'Night club',
        ],
        'Snacks' => [
            'Snack bar with burgers',
            'Snack bar with burrito',
            'Snack with hot dogs',
            'Snack with dumplings',
            'Snack with pancake',
        ],
        'Other' => [
            'Sweet shop',
            'Chocolate shop',
            'Confectionery',
            'Park',
            'Cinema',
            'Theater',
            'Book Shop',
        ],

    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = PlaceCategory::all();
        $tags = PlaceCategoryTag::all();

        foreach ($categories as $category) {
            $category
                ->tags()
                ->saveMany(
                    $tags
                        ->whereIn(
                            'name', self::DATA[$category->name]
                        )
                        ->all()
                );
        }
    }
}
