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
        $this->call( ReviewLikeDislikeSeeder::class);
    }
}
