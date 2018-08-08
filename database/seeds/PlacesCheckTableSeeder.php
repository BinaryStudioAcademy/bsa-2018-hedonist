<?php

use Illuminate\Database\Seeder;

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
        $users = \Hedonist\Entities\User\User::all();
        $places = \Hedonist\Entities\Place\Place::all();

        foreach ($places as $place){
            $placesId[] = $place->id;
        }

        foreach ($users as $user) {
            factory(\Hedonist\Entities\Place\PlaceCheckin::class)->create([
                'user_id' => $user->id,
                'place_id' => array_random($placesId)
            ]);
        }
    }
}
