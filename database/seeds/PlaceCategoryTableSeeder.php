<?php

use Illuminate\Database\Seeder;
use Hedonist\Entities\Place\PlaceCategory;
use Illuminate\Support\Facades\DB;

class PlaceCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PlaceCategory::query()->insert([
            [
                'name' => 'Bar',
                'logo' => 'https://irs1.4sqi.net/img/general/cap/120/dialpad_drinks_20180129.png'
            ],
            [
                'name' => 'Beer',
                'logo' => 'https://cdn.icon-icons.com/icons2/1315/PNG/512/if-beergermanyoktoberfestnationeurope-2596560_86604.png'
            ],
            [
                'name' => 'Restaurant',
                'logo' => 'https://irs1.4sqi.net/img/general/cap/120/dialpad_food_20180129.png'
            ],
            [
                'name' => 'Cafeteria',
                'logo' => 'https://static.thenounproject.com/png/77211-200.png'
            ],
            [
                'name' => 'Cafe',
                'logo' => 'https://irs1.4sqi.net/img/general/cap/120/dialpad_coffee_20180129.png'
            ],
            [
                'name' => 'Snacks',
                'logo' => 'https://irs1.4sqi.net/img/general/cap/120/dialpad_breakfast_20180129.png'
            ],
            [
                'name' => 'Other',
                'logo' => 'https://irs1.4sqi.net/img/general/cap/120/dialpad_trendingthismonth_20180129.png'
            ]
        ]);
    }
}