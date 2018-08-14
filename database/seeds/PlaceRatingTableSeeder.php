<?php

use Illuminate\Database\Seeder;

class PlaceRatingTableSeeder extends Seeder
{
    public function run()
    {
        factory(\Hedonist\Entities\Place\PlaceRating::class, 12)->create();
    }
}
