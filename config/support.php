<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application URLs
    |--------------------------------------------------------------------------
    |
    | Here you may define all of your application URLs, with format
    | "identifier => url". The domain of each URL is avaliable in
    | "app.domains" configuration.
    |
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
    |
    | Here you may define the cookie domain for a special application identifier.
    |
    */

    'cookie_domain' => [
        'admin' => env('SESSION_DOMAIN_ADMIN', null),
        'api' => env('SESSION_DOMAIN_API', null),
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentications Defaults
    |--------------------------------------------------------------------------
    |
    | Here you may define the authentication "guard" and password reset options
    | for a special application identifier.
    |
    */

    'auth' => [
        'admin' => [
            'guard' => 'admin',
            'passwords' => 'admin_users',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Int2string
    |--------------------------------------------------------------------------
    |
    | Characters for `Helper::int2string()` and `Helper::string2int()`.
    | You may generate it using
    | `php artisan support:generate-int2string-characters` command.
    |
    */

    'int2string' => env('INT2STRING_CHARACTERS', '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'),

    /*
    |--------------------------------------------------------------------------
    | Optimus ID Transformation
    |--------------------------------------------------------------------------
    |
    | More info: https://github.com/jenssegers/optimus#usage
    |
    | - Large prime number lower than 2147483647
    | - The inverse prime so that (PRIME * INVERSE) & MAXID == 1
    | - A large random integer lower than 2147483647
    |
    | You may generate them using `php artisan support:generate-optimus` command.
    |
    */

    'optimus' => [
        'prime' => env('OPTIMUS_PRIME'),
        'inverse' => env('OPTIMUS_INVERSE'),
        'random' => env('OPTIMUS_RANDOM'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Gravatar Service
    |--------------------------------------------------------------------------
    */

    'gravatar' => [
        'host' => 'https://www.gravatar.com/avatar',
        'default' => 'identicon',
        'rating' => 'pg',
    ],

    /*
    |--------------------------------------------------------------------------
    | Tencent Xinge Push Service
    |--------------------------------------------------------------------------
    */

    'xgpush' => [
        'key' => env('XGPUSH_KEY'),
        'secret' => env('XGPUSH_SECRET'),
        'environment' => env('XGPUSH_ENVIRONMENT', env('APP_ENV')),
        'custom_key' => 'my',
        'account_prefix' => 'user',
    ],

];
