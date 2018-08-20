<?php

use Illuminate\Database\Seeder;
use \Hedonist\Entities\Place\Place;
use \Hedonist\Entities\User\User;
use Hedonist\Entities\Review\Review;


class _ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $places = Place::all();

        $places->map(function ($place) {
            factory(Review::class)->create([
                'user_id' => User::all()->random()->id,
                'place_id' => $place->id
            ]);
        });
    }
}
