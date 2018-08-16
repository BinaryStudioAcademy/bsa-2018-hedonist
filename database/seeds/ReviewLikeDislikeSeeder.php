<?php

use Illuminate\Database\Seeder;
use Hedonist\Entities\Review\Review;
use Hedonist\Entities\Like\Like;
use Hedonist\Entities\User\User;
use Hedonist\Entities\Dislike\Dislike;

class ReviewLikeDislikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Review::all()->map(function ($item) {
            $random = rand(0, 10);
            if ($random <= 5) {
                $item->likes()->save(new Like([
                    'user_id' => User::all()->random()->getKey(),
                    'likeable_type' => Review::class,
                    'likeable_id' => $item->id
                ]));
            } else {
                $item->dislikes()->save(new Dislike([
                    'user_id' => User::all()->random()->getKey(),
                    'dislikeable_type' => Review::class,
                    'dislikeable_id' => $item->id
                ]));
            }
        });
    }
}
