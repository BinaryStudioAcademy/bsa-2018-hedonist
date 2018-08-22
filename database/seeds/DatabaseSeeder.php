<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserTableSeeder::class);
        $this->call(PlaceCategoryTableSeeder::class);
        $this->call(PlaceCategoriesTagsTableSeeder::class);
        $this->call(PlaceCategoriesAttachTagsSeeder::class);
        $this->call(PlacesFeaturesTableSeeder::class);
        $this->call(CityTableSeeder::class);
        $this->call(PlaceTableSeeder::class);
        $this->call(PlaceTagTableSeeder::class);
        $this->call(PlacesCheckTableSeeder::class);
        $this->call(ReviewSeeder::class);
        $this->call(ReviewLikeDislikeSeeder::class);
        $this->call(PlaceRatingTableSeeder::class);
        $this->call(PlacesAttachFeaturesTableSeeder::class);
    }
}
