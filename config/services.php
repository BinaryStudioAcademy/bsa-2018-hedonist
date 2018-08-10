<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => env('SES_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => Hedonist\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'loggly' => [
        'key' => env('LOGGLY_KEY'),
        'tag' => 'BsaHedonist_' . strtolower(env('APP_ENV')),
    ],

    'facebook' => [
        'client_id' => env('FACEBOOK_CLIENT_ID',''),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET',''),
        'redirect' => env('FACEBOOK_REDIRECT',''),
    ],
];
