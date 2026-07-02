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



    // ... outros serviços

'mpesa' => [
    'timeout' => env('MPESA_TIMEOUT', 120),
    'connect_timeout' => env('MPESA_CONNECT_TIMEOUT', 60),
    'retry_times' => env('MPESA_RETRY_TIMES', 3),
    'retry_sleep' => env('MPESA_RETRY_SLEEP', 1000),
    'base_url' => env('MPESA_BASE_URL', 'https://api.sandbox.vm.co.mz:18352'),
    'service_provider_code' => env('MPESA_SERVICE_PROVIDER_CODE', '171717'),
],


    // other configurations...


    'twilio' => [
        'sid' => env('TWILIO_SID'),
        'token' => env('TWILIO_TOKEN'),
        'from' => env('TWILIO_FROM'),
    ],

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

];
