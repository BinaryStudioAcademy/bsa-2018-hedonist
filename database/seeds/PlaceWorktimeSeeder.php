<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Hedonist\Entities\Place\Place;

class PlaceWorktimeSeeder extends Seeder
{
    const DAYCODES = ['mo', 'tu', 'we', 'th', 'fr', 'sa', 'su'];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $places = Place::all();
        $start_time = Carbon::parse('today 7 hours', 'UTC');
        $end_time = Carbon::parse('today 18 hours', 'UTC');

        foreach ($places as $place) {
            foreach (self::DAYCODES as $daycode) {
                $place->worktime()->create([
                    'place_id'   => $place->id,
                    'day_code'   => $daycode,
                    'start_time' => $start_time,
                    'end_time'   => $end_time
                ]);
            }
        }
    }
}
