<?php

use Illuminate\Database\Seeder;
use \Hedonist\Entities\Place\Place;
use \Hedonist\Entities\User\User;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $reviews = factory(\Hedonist\Entities\Review\Review::class, 10)->make();
        $reviews->map(function ($item) {
            $item->user_id = User::all()->random()->getKey();
            $item->place_id = Place::all()->random()->getKey();
            $item->save();
        });
        //force first place to have a review with real user data
        $real_review = factory(\Hedonist\Entities\Review\Review::class)->make();
        $real_review->user_id = User::all()->first();
        $real_review->place_id = Place::all()->first();
        $real_review->save();
    }
}
