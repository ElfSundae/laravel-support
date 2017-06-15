<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application URLs
    |--------------------------------------------------------------------------
    */

    'url' => [
        'site' => env('APP_URL'),
        'admin' => env('APP_URL_ADMIN', env('APP_URL')),
        'api' => env('APP_URL_API', env('APP_URL')),
        'asset' => env('APP_URL_ASSET', env('APP_URL')),
        'cdn' => env('APP_URL_CDN', env('APP_URL')),
    ],

    /*
    |--------------------------------------------------------------------------
    | Session Cookie Domains
    |--------------------------------------------------------------------------
    */

    'cookie_domain' => [
        'admin' => env('SESSION_DOMAIN_ADMIN', null),
        'api' => env('SESSION_DOMAIN_API', null),
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentications Defaults
    |--------------------------------------------------------------------------
    */

    'auth' => [
        'admin' => [
            'guard' => 'admin',
            'passwords' => 'admin_users',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Characters for int2string
    |--------------------------------------------------------------------------
    |
    | Characters for `Helper::int2string()` and `Helper::string2int()`.
    | You may generate it via `php artisan support:int2string-characters`.
    |
    */

    'int2string' => env('INT2STRING_CHARACTERS', '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'),

];
