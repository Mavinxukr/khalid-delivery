<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],
    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],
    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'google' => [
        'client_id' => env('GOOGLE_KEY'),
        'client_secret' => env('GOOGLE_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT_URI')
    ],
    'facebook' => [
        'client_id' => env('FACEBOOK_APP_ID'),
        'client_secret' => env('FACEBOOK_APP_SECRET'),
        'redirect' => env('FACEBOOK_REDIRECT'),
    ],
    'twitter' => [
        'client_id' => env('TWITTER_KEY'),
        'client_secret' =>  env('TWITTER_SECRET'),
        'redirect' => env('TWITTER_REDIRECT_URI'),
    ],
    'snapchat' => [
        'client_id' => env('SNAPCHAT_KEY'),
        'client_secret' => env('SNAPCHAT_SECRET'),
        'redirect' => env('SNAPCHAT_REDIRECT_URI')
    ],

    'checkout_pay' => [
        'sk_test_key' => env('CHECKOUT_SK_KEY'),
        'pk_test_key' => env('CHECKOUT_PK_KEY')
    ],

    'apple' => [
        "login" => env("SIGN_IN_WITH_APPLE_LOGIN"),
        "redirect" => env("SIGN_IN_WITH_APPLE_REDIRECT"),
        "client_id" => env("SIGN_IN_WITH_APPLE_CLIENT_ID"),
        "client_secret" => env("SIGN_IN_WITH_APPLE_CLIENT_SECRET"),
    ]
];
