<?php

use Illuminate\Database\Seeder;
use Hedonist\Entities\User\User;
use Hedonist\Entities\Place\City;
use Hedonist\Entities\Place\Place;
use Hedonist\Entities\Place\PlaceCategory;
use Hedonist\Entities\Localization\Language;
use Hedonist\Entities\Localization\PlaceTranslation;
use Hedonist\Entities\Place\PlacePhoto;

use Faker\Factory as Faker;

class PlaceTableSeeder extends Seeder
{
    private const CITIES = [
        [
            'name' => 'Kiev',
            'coordinates' => ['lat' => 50.4547, 'lng' => 30.5238],
            'radius' => 0.06,
        ],[
            'name' => 'Lviv',
            'coordinates' => ['lat' => 49.8397, 'lng' => 24.0297],
            'radius' => 0.03,
        ],[
            'name' => 'Dnipro',
            'coordinates' => ['lat' => 48.4647, 'lng' => 35.0462],
            'radius' => 0.03,
        ],[
            'name' => 'Kharkiv',
            'coordinates' => ['lat' => 49.9935, 'lng' => 36.2304],
            'radius' => 0.04,
        ],[
            'name' => 'Khmelnytskyi',
            'coordinates' => ['lat' => 49.4230, 'lng' => 26.9871],
            'radius' => 0.02,
        ],[
            'name' => 'Cherkasy',
            'coordinates' => ['lat' => 49.4444, 'lng' => 32.0598],
            'radius' => 0.02,
        ],[
            'name' => 'Chernivtsi',
            'coordinates' => ['lat' => 48.2921, 'lng' => 25.9358],
            'radius' => 0.02,
        ],[
            'name' => 'Chernihiv',
            'coordinates' => ['lat' => 51.4982, 'lng' => 31.2893],
            'radius' => 0.03,
        ],[
            'name' => 'Odessa',
            'coordinates' => ['lat' => 46.4825, 'lng' => 30.7233],
            'radius' => 0.02,
        ]
    ];

    private
    const PLACE_NAMES = [
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

    public function run() : void
    {
        $faker = Faker::create();

        $language = factory(Language::class)->create([
            'code' => 'en',
            'active' => true,
            'default' => true,
        ]);

       foreach (self::CITIES as $city) {

           $cityName = $city['name'];
           $lng = $city['coordinates']['lng'];
           $lat = $city['coordinates']['lat'];
           $radius = $city['radius'];

           foreach (self::PLACE_NAMES as $placeName) {
               $place = factory(Place::class)->create([
                   'city_id' => City::where('name', $cityName)->first()->id,
                   'creator_id' => User::inRandomOrder()->first()->id,
                   'category_id' => PlaceCategory::inRandomOrder()->first()->id,
                   'longitude' => $faker->unique()->randomFloat(6, $lng - $radius, $lng + $radius),
                   'latitude' => $faker->unique()->randomFloat(6, $lat - $radius, $lat + $radius),
               ]);

               $placeTranslation = factory(PlaceTranslation::class)->create([
                   'place_name' => $placeName . ' ' . $cityName,
                   'place_id' => $place->id,
                   'language_id' => $language->id
               ]);

               factory(PlacePhoto::class)->create([
                   'place_id' => $place->id,
                   'creator_id' => User::inRandomOrder()->first()->id,
               ]);
           }
       }
    }
}