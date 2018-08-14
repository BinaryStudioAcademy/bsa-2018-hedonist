<?php

use Illuminate\Database\Seeder;
use Hedonist\Entities\User\User;
use Hedonist\Entities\Place\Place;

class PlacesCheckTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $placesId = [];
        $users = User::all();
        $places = Place::all();

        foreach ($places as $place) {
            $placesId[] = $place->id;
        }

        foreach ($users as $user) {
            factory(\Hedonist\Entities\Place\Checkin::class)->create([
                'user_id' => $user->id,
                'place_id' => array_random($placesId)
            ]);
        }
    }
}
