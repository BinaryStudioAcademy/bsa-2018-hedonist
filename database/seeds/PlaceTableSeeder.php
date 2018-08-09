<?php

use Hedonist\Entities\Place\City;
use Hedonist\Entities\Place\Place;
use Illuminate\Database\Seeder;
use Hedonist\Entities\Localization\PlaceTranslation;
use Hedonist\Entities\Localization\Language;


class PlaceTableSeeder extends Seeder
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

    private const PLACE_NAMES = [
        "Red Cat",
        "Plates & Cups",
        "SOWA",
        "Croissants",
        "Food and Good",
        "Fixage",
        "Diana",
        "Glory Cafe",
        "Veronika",
        "Kredens Cafe",
        "Agrus",
        "Ratusha",
        "L'affinage cheese&wine",
        "SelfieCoffee",
        "Blackwood Coffee",
        "Tarta Cafe",
        "Druzi",
        "The Blue Cup",
        "Honey",
        "Aroma Espresso Bar",
        "Milk Bar",
        "L'kafa",
        "City-Zen cafe"
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $language = factory(Language::class)->create([
            'code' => 'en',
            'active' => true,
            'default' => true,
        ]);

        foreach (self::PLACE_NAMES as $placeName) {
            $city = factory(City::class)->create([
                'name' => array_random(self::CITY_NAMES)
            ]);
            $place = factory(Place::class)->create([
                'city_id' => $city->id,
            ]);
            $placeTranslation = factory(PlaceTranslation::class)->create([
                'place_name' => $placeName,
                'place_id' => $place->id,
                'language_id' => $language->id
            ]);
        }
    }
}