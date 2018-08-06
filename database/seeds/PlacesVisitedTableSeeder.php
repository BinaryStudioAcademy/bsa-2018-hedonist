<?php

use Illuminate\Database\Seeder;
use Hedonist\Entities\Place\PlacesVisited;

class PlacesVisitedTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        for ($i = 1; $i <= 10; $i++)
        {
            factory(PlacesVisited::class)->create([
                'id' => $i,
                'user_id' => $i,
                'place_id' => rand(1,10)
            ]);
        }
    }
}
