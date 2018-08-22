<?php

use Illuminate\Database\Seeder;
use Hedonist\Entities\Place\PlaceRating;
use Hedonist\Entities\User\User;
use Hedonist\Entities\Place\Place;

class PlaceRatingTableSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();
        $places = Place::all();

        foreach ($users as $user) {
            foreach ($places as $place) {
                factory(PlaceRating::class)->create([
                    'user_id' => $user->id,
                    'place_id' => $place->id
                ]);
            }
        }
    }
}
