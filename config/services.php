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

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'stripe' => [
        'prices' => [
            'individual_monthly' => env('STRIPE_PRICE_INDIVIDUAL_MONTHLY', 'price_1TFgXeCcmLy5PiLsbrLtDCfP'),
            'individual_yearly'  => env('STRIPE_PRICE_INDIVIDUAL_YEARLY', 'price_1TFgXKCcmLy5PiLs5xZdP87O'),
            'company'            => env('STRIPE_PRICE_COMPANY', 'price_1TM7hJCcmLy5PiLsPioHECxJ'),
        ],
    ],

];
