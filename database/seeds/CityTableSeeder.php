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

    private const CITY_LOCATION = [
        'Kiev' => [
            'lng' => 30.5241,
            'lat' => 50.4501
        ],
        'Lviv' => [
            'lng' => 24.0316,
            'lat' => 49.842
        ],
        'Dnipro' => [
            'lng' => 35.05,
            'lat' => 48.47
        ],
        'Kharkiv' => [
            'lng' => 36.2304,
            'lat' => 49.9903
        ],
        'Khmelnytskyi' => [
            'lng' => 26.9794,
            'lat' => 49.4196
        ],
        'Cherkasy' => [
            'lng' => 32.0588,
            'lat' => 49.4448
        ],
        'Chernivtsi' => [
            'lng' => 25.9377,
            'lat' => 48.2865
        ],
        'Chernihiv' => [
            'lng' => 31.2943,
            'lat' => 51.4941
        ],
        'Odessa' => [
            'lng' => 30.7326,
            'lat' => 46.4846
        ]
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
                'name' => $cityName,
                'longitude' => self::CITY_LOCATION[$cityName]['lng'],
                'latitude' => self::CITY_LOCATION[$cityName]['lat']
            ]);
        }
    }
}