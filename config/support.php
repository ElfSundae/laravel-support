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
        'web' => env('APP_URL'),
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
        'web' => env('SESSION_DOMAIN', null),
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
    | Carbon Datetime Translator Locale
    |--------------------------------------------------------------------------
    |
    | All avaliable locales are located in
    | "/vendor/nesbot/carbon/src/Carbon/Lang" directory.
    |
    */

    'carbon_locale' => 'zh',

    /*
    |--------------------------------------------------------------------------
    | Fake App Client
    |--------------------------------------------------------------------------
    |
    | You may configure a fake app client for local testing.
    |
    | See `Support\Providers\AppServiceProvider::getUserAgentForFakeAppClient()`.
    |
    */

    'fake_app_client' => [
        'os' => 'iOS',
        'osVersion' => '9.3.3',
        'platform' => 'iPhone7,1',
        'locale' => 'zh_CN',
        'app' => 'FakeAppClient',
        'appVersion' => '1.0.0',
        'appChannel' => 'App Store',
        'network' => 'WiFi',
        'udid' => '000000000000000000000000000000',
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
    |
    | https://gravatar.com
    |
    */

    'gravatar' => [
        'host' => 'https://v2ex.assets.uxengine.net/gravatar',
        'default' => 'identicon',
        'rating' => 'pg',
    ],

    /*
    |--------------------------------------------------------------------------
    | Google Analytics
    |--------------------------------------------------------------------------
    |
    | id : 'UA-xxxxxxxx-x'
    | cookie_domain : 'auto' // 'none' // 'example.com'
    |
    */

    'google_analytics' => [
        'id' => env('GOOGLE_ANALYTICS_ID'),
        'cookie_domain' => env('GOOGLE_ANALYTICS_COOKIE_DOMAIN', 'auto'),
    ],

];
