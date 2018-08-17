<?php

use Faker\Generator as Faker;
use Hedonist\Entities\Place\PlacePhoto;
use Hedonist\Entities\Place\Place;
use Hedonist\Entities\User\User;

$factory->define(PlacePhoto::class, function (Faker $faker) {

    $photos = [
        'https://igx.4sqi.net/img/general/200x200/887035_CLhGX1rsu2-V75shOAkPWuxXLY2k4iO17hEdOlOfSWc.jpg',
        'https://igx.4sqi.net/img/general/200x200/26166006_NbsG6630seaUu5oBMHF1nJN5faMbAJBB-U_fftfgLQ0.jpg',
        'https://igx.4sqi.net/img/general/200x200/14194563_V7QcNe7QxElooKfHflch-zJsOky6c58iNIMq5_gqf2g.jpg',
        'https://igx.4sqi.net/img/general/200x200/30460270_jXczXSrGxp69jx5_iU-NXRoxXfZl1OKMqrbSRL5IOh4.jpg',
        'https://igx.4sqi.net/img/general/200x200/49523061_7l_R5LyP657g624USxZ_oomdQ3QkqJyI0OvSdKGQLsY.jpg',
        'https://igx.4sqi.net/img/general/200x200/43170088_MOsT6vDk8CrgoM8hMPQ2Ex1OLGUR3SBJJP8CKK317_s.jpg',
        'https://igx.4sqi.net/img/general/200x200/5131275_W0cHIwqqMi95dCIhgAiTdDFBySZL4xsS93Prjxv8GJM.jpg',
        'https://igx.4sqi.net/img/general/200x200/83196834_6Jkr24BOV5h52EMvb8cy9oeP5IdcZdSfmNzazYBEz_g.jpg',
        'https://igx.4sqi.net/img/general/200x200/81501175_U8dlSYQ2mFeWzRszG5Pu57VRW2CdwypUC3ofR8dnT1I.jpg',
        'https://igx.4sqi.net/img/general/200x200/127740585_BCMwhYAAZ8lyVb5wdDXytxSRSPdBkjaYY6pFRO6yW-g.jpg',
        'https://igx.4sqi.net/img/general/200x200/105415509_EgiwmKD9QYjKut0p9Fuj4FmUM3qJIX2LFsORO3R9P58.jpg',
        'https://igx.4sqi.net/img/general/200x200/91146561_OPnRUeFJtkM8ZNTdkK4VhAnY99eqHtzGqY9EykWU22A.jpg'
    ];

    $dimension = $faker->numberBetween(200, 900);
    return [
        'place_id' => function () {
            return factory(Place::class)->create()->id;
        },
        'creator_id' => function () {
            return factory(User::class)->create()->id;
        },
        'img_url' => $faker->randomElement($photos),
        'description' => $faker->sentence(3),
        'width' => $dimension,
        'height' => $dimension,
    ];
});
