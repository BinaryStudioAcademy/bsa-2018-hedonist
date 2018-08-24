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
        $users = User::all();
        $places = Place::all();

        foreach ($users as $user) {
            for ($i = 0; $i < 15; $i++) {
                factory(\Hedonist\Entities\Place\Checkin::class)->create([
                    'user_id' => $user->id,
                    'place_id' => $places->random()->id
                ]);
            }
        }
    }
}
