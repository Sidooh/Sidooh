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

    'at' => [
        'key' => env('AT_API_KEY'),
        'username' => env('AT_USERNAME'),
        'phone' => env('AT_PHONE'),
        'env' => env('AT_ENV', 'local'),

        'sms' => [
            'key' => env('AT_SMS_API_KEY'),
            'username' => env('AT_SMS_USERNAME'),
            'from' => env('AT_SMS_FROM'),
        ],
        'airtime' => [
            'key' => env('AT_AIRTIME_API_KEY'),
            'username' => env('AT_AIRTIME_USERNAME'),
        ],
    ],

];
