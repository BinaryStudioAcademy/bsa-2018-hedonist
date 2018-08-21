<?php

use Illuminate\Database\Seeder;
use Hedonist\Entities\Place\City;
use Illuminate\Support\Facades\DB;

class CityTableSeeder extends Seeder
{
    private const CITY_NAMES = [
        "Kiev",
        "Lviv",
        "Dnipro",
        "Kharkiv",
        "Khmelnytskyi",
        "Cherkasy",
        "Chernivtsi",
        "Chernihiv",
        "Odessa"
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (self::CITY_NAMES as $cityName) {
            $city = factory(City::class)->create([
                'name' => $cityName
            ]);
        }
    }
}