<?php

use Illuminate\Database\Seeder;
use Hedonist\Entities\PlaceList\PlaceList;

class PlaceListTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(PlaceList::class,3)->create();
    }
}
