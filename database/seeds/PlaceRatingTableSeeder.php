<?php

use Illuminate\Database\Seeder;
use Hedonist\Entities\Place\PlaceRating;

class PlaceRatingTableSeeder extends Seeder
{
    public function run()
    {
        factory(PlaceRating::class, 200)->create();
    }
}
