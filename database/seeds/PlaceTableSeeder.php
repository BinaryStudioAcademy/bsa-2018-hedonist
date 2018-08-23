<?php

use Illuminate\Database\Seeder;
use Hedonist\Entities\User\User;
use Hedonist\Entities\Place\City;
use Hedonist\Entities\Place\Place;
use Hedonist\Entities\Place\PlaceCategory;
use Hedonist\Entities\Localization\Language;
use Hedonist\Entities\Localization\PlaceTranslation;
use Hedonist\Entities\Place\PlacePhoto;
use Hedonist\Entities\Place\PlaceInfo;
use Faker\Factory as Faker;

class PlaceTableSeeder extends Seeder
{
    private const CITIES = [
        [
            'name' => 'Kiev',
            'coordinates' => ['lat' => 50.4547, 'lng' => 30.5238],
            'radius' => 0.06,
        ], [
            'name' => 'Lviv',
            'coordinates' => ['lat' => 49.8397, 'lng' => 24.0297],
            'radius' => 0.03,
        ], [
            'name' => 'Dnipro',
            'coordinates' => ['lat' => 48.4647, 'lng' => 35.0462],
            'radius' => 0.03,
        ], [
            'name' => 'Kharkiv',
            'coordinates' => ['lat' => 49.9935, 'lng' => 36.2304],
            'radius' => 0.04,
        ], [
            'name' => 'Khmelnytskyi',
            'coordinates' => ['lat' => 49.4230, 'lng' => 26.9871],
            'radius' => 0.02,
        ], [
            'name' => 'Cherkasy',
            'coordinates' => ['lat' => 49.4444, 'lng' => 32.0598],
            'radius' => 0.02,
        ], [
            'name' => 'Chernivtsi',
            'coordinates' => ['lat' => 48.2921, 'lng' => 25.9358],
            'radius' => 0.02,
        ], [
            'name' => 'Chernihiv',
            'coordinates' => ['lat' => 51.4982, 'lng' => 31.2893],
            'radius' => 0.03,
        ], [
            'name' => 'Odessa',
            'coordinates' => ['lat' => 46.4825, 'lng' => 30.7233],
            'radius' => 0.02,
        ]
    ];

    private const PLACES = [
        [
            'name' => "Red Cat",
            'img_url' => 'https://igx.4sqi.net/img/general/width960/DkrsZ_vVxHfEvT2iOMp1jrreHWe2qC_7W0rs6MmRrpg.jpg',
        ],
        [
            'name' => "Plates & Cups",
            'img_url' => 'https://igx.4sqi.net/img/general/width960/200775283_9BcJTpT8cqbLyu7b3NifXmrykR01JWcXZzyJvFdDY98.jpg',
        ],
        [
            'name' => "SOWA",
            'img_url' => 'https://igx.4sqi.net/img/general/width960/27381066_k87F2v_9Ia4ku4AlkoFdSlOGZ2e2RrpAZUMXEo3I1aE.jpg',
        ],
        [
            'name' => "Croissants",
            'img_url' => 'https://igx.4sqi.net/img/general/width960/887035_CLhGX1rsu2-V75shOAkPWuxXLY2k4iO17hEdOlOfSWc.jpg',
        ],
        [
            'name' => "Food and Good",
            'img_url' => 'https://igx.4sqi.net/img/general/width960/77825413_IO39NF60IBOLUJTQUjo_6yJvCnM7V4Kfc4K0T2Tyn7w.jpg',
        ],
        [
            'name' => "Fixage",
            'img_url' => 'https://igx.4sqi.net/img/general/width960/18744269_t7NmmtSLC9-a49KBCzEEHSevVJQ_s658tl1yYgOC8RA.jpg',
        ],
        [
            'name' => "Diana",
            'img_url' => 'https://igx.4sqi.net/img/general/width960/39355032_huh3OTmAp_nlo-yY4Xy_AVwUcO6Uoq-UifIgGhL4yRo.jpg',
        ],
        [
            'name' => "Glory Cafe",
            'img_url' => 'https://igx.4sqi.net/img/general/width960/39095144_TSyO5qlR85WHNtJnP2Acg-JZPNklhXhdx0LQIANzcbQ.jpg',
        ],
        [
            'name' => "Veronika",
            'img_url' => 'https://igx.4sqi.net/img/general/width960/58786483_iYz5EcoRlclnHGAuRHeNggHptWOakN-hZi0hg9aCJfE.jpg',
        ],
        [
            'name' => "Kredens Cafe",
            'img_url' => 'https://igx.4sqi.net/img/general/width960/332099702_l80MuOfqsOaHR2c0j18msi7UFuzT2SWkHJKA1pvUqEk.jpg',
        ],
        [
            'name' => "Agrus",
            'img_url' => 'https://igx.4sqi.net/img/general/width960/103613964_tbkqTPV1ndnBk6dGZAiZUnLk6TleXsGlctpzoOhTg3c.jpg',
        ],
        [
            'name' => "Ratusha",
            'img_url' => 'https://igx.4sqi.net/img/general/width960/91848606_7s2MlUaTq44FYNaKskPEOsjIA42F6xYrD14Ilqeo7EM.jpg',
        ],
        [
            'name' => "L'affinage cheese&wine",
            'img_url' => 'https://igx.4sqi.net/img/general/width960/447201471_WLxH4tZhbfIA5zxRtKqyGq7n5HJIW9P9Om16iXaO6-s.jpg',
        ],
        [
            'name' => "SelfieCoffee",
            'img_url' => 'https://igx.4sqi.net/img/general/width960/17700383_UUNtffUIrXMm8VyNghmIzp2R9JOlR7Ip4C_mfMJNDO4.jpg',
        ],
        [
            'name' => "Blackwood Coffee",
            'img_url' => 'https://igx.4sqi.net/img/general/width960/28171699_eHlER8a4ptHBtvRnkDXkNj47HpL4KfSDUo7aaL7VsWQ.jpg',
        ],
        [
            'name' => "Tarta Cafe",
            'img_url' => 'https://igx.4sqi.net/img/general/width960/16644285_h1BNy0RmrSTR829S9H5p3W0mrQxDQCd8P3xl5bBlZro.jpg',
        ],
        [
            'name' => "Druzi",
            'img_url' => 'https://igx.4sqi.net/img/general/width960/473118684__S6VWo02TbqQuXudPZjdyKrmXPF6o7Aj0QQv8utJHvg.jpg',
        ],
        [
            'name' => "The Blue Cup",
            'img_url' => 'https://igx.4sqi.net/img/general/width960/48811174_MPFbFMEzXOC0HTlhIZEb-bfcaPFxfZLJ6lhAzkwH3Nw.jpg',
        ],
        [
            'name' => "Honey",
            'img_url' => 'https://igx.4sqi.net/img/general/width960/119943044_6SDGf6xWxbwYJHVTyMVKNe_cXQKzhpsd7HOzCu0HAno.jpg',
        ],
        [
            'name' => "Aroma Espresso Bar",
            'img_url' => 'https://igx.4sqi.net/img/general/width960/431140131_nxLAzhiGVl9p8JEl3bot2hVtoW7W6Y4WT7T6TFJykwU.jpg',
        ],
        [
            'name' => "Milk Bar",
            'img_url' => 'https://igx.4sqi.net/img/general/width960/16459303_TxsbkNy2-bKd1RzfDq0cI-SeAp-2Mtc1NLZJ9Mb-rY4.jpg',
        ],
        [
            'name' => "L'kafa",
            'img_url' => 'https://igx.4sqi.net/img/general/width960/71577744_afIrVJ-RNcJFMst_Hx0LO1-XBp27Ze-3RdfSHznOfcw.jpg',
        ],
        [
            'name' => "City-Zen cafe",
            'img_url' => 'https://igx.4sqi.net/img/general/width960/27888382_dg90jR5EjwaqkGAqZZ0uxKUlmkx8tytv9aj5bYYCJvM.jpg',
        ],
    ];

    const IMAGES = [
        'https://igx.4sqi.net/img/general/width960/887035_CLhGX1rsu2-V75shOAkPWuxXLY2k4iO17hEdOlOfSWc.jpg',
        'https://igx.4sqi.net/img/general/width960/26166006_NbsG6630seaUu5oBMHF1nJN5faMbAJBB-U_fftfgLQ0.jpg',
        'https://igx.4sqi.net/img/general/width960/14194563_V7QcNe7QxElooKfHflch-zJsOky6c58iNIMq5_gqf2g.jpg',
        'https://igx.4sqi.net/img/general/width960/30460270_jXczXSrGxp69jx5_iU-NXRoxXfZl1OKMqrbSRL5IOh4.jpg',
        'https://igx.4sqi.net/img/general/width960/49523061_7l_R5LyP657g624USxZ_oomdQ3QkqJyI0OvSdKGQLsY.jpg',
        'https://igx.4sqi.net/img/general/width960/43170088_MOsT6vDk8CrgoM8hMPQ2Ex1OLGUR3SBJJP8CKK317_s.jpg',
        'https://igx.4sqi.net/img/general/width960/5131275_W0cHIwqqMi95dCIhgAiTdDFBySZL4xsS93Prjxv8GJM.jpg',
        'https://igx.4sqi.net/img/general/width960/83196834_6Jkr24BOV5h52EMvb8cy9oeP5IdcZdSfmNzazYBEz_g.jpg',
        'https://igx.4sqi.net/img/general/width960/81501175_U8dlSYQ2mFeWzRszG5Pu57VRW2CdwypUC3ofR8dnT1I.jpg',
        'https://igx.4sqi.net/img/general/width960/127740585_BCMwhYAAZ8lyVb5wdDXytxSRSPdBkjaYY6pFRO6yW-g.jpg',
        'https://igx.4sqi.net/img/general/width960/105415509_EgiwmKD9QYjKut0p9Fuj4FmUM3qJIX2LFsORO3R9P58.jpg',
        'https://igx.4sqi.net/img/general/width960/91146561_OPnRUeFJtkM8ZNTdkK4VhAnY99eqHtzGqY9EykWU22A.jpg'
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
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

            foreach (self::PLACES as $placeInfo) {
                $place = factory(Place::class)->create([
                    'city_id' => City::where('name', $cityName)->first()->id,
                    'creator_id' => User::inRandomOrder()->first()->id,
                    'category_id' => PlaceCategory::inRandomOrder()->first()->id,
                    'longitude' => $faker->unique()->randomFloat(6, $lng - $radius, $lng + $radius),
                    'latitude' => $faker->unique()->randomFloat(6, $lat - $radius, $lat + $radius),
                ]);

                factory(PlaceTranslation::class)->create([
                    'place_name' => $placeInfo['name'],
                    'place_id' => $place->id,
                    'language_id' => $language->id
                ]);

                foreach (self::IMAGES as $imageUrl) {
                    factory(PlacePhoto::class)->create([
                        'place_id' => $place->id,
                        'creator_id' => User::inRandomOrder()->first()->id,
                        'img_url' => $imageUrl
                    ]);
                }

                factory(PlaceInfo::class)->create([
                    'place_id' => $place->id
                ]);
            }
        }
    }
}