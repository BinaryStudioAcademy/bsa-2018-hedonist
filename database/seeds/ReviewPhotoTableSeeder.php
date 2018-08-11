<?php

use Illuminate\Database\Seeder;
use Hedonist\Entities\Review\ReviewPhoto;

class ReviewPhotoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(ReviewPhoto::class, 3)->create();
    }
}
