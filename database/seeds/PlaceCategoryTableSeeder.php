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
                'logo' => '/upload/category_icon/bar.png'
            ],
            [
                'name' => 'Beer',
                'logo' => '/upload/category_icon/beer.png'
            ],
            [
                'name' => 'Restaurant',
                'logo' => '/upload/category_icon/restaurant.png'
            ],
            [
                'name' => 'Cafeteria',
                'logo' => '/upload/category_icon/cafeteria.png'
            ],
            [
                'name' => 'Cafe',
                'logo' => '/upload/category_icon/cafe.png'
            ],
            [
                'name' => 'Snacks',
                'logo' => '/upload/category_icon/snaks.png'
            ],
            [
                'name' => 'Other',
                'logo' => '/upload/category_icon/other.png'
            ]
        ]);
    }
}