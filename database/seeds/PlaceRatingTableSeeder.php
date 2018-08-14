<?php

use Illuminate\Database\Seeder;

class PlaceRatingTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('places_rating')->delete();
        factory(\Hedonist\Entities\Place\PlaceRating::class, 12)->create();
    }
}
