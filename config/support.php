<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application URLs
    |--------------------------------------------------------------------------
    |
    | Here you may specify the root URL for each sub application.
    | The domain of each URL will be avaliable under
    | "support.domain" configuration.
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
    | Application Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may override the default configuration for each sub application.
    |
    */

    'config' => [
        'default' => [
            'app.timezone' => 'Asia/Shanghai',
            'app.locale' => 'zh-CN',
            'app.faker_locale' => 'zh_CN',
            'app.log' => env('APP_LOG', 'daily'),

            'auth.guards.admin' => [
                'driver' => 'session',
                'provider' => 'admin_users',
            ],
            'auth.providers.users' => [
                'driver' => 'eloquent',
                'model' => App\Models\User::class,
            ],
            'auth.providers.admin_users' => [
                'driver' => 'eloquent',
                'model' => App\Models\AdminUser::class,
            ],
            'auth.passwords.admin_users' => [
                'provider' => 'admin_users',
                'table' => 'admin_password_resets',
                'expire' => 60,
            ],

            'cache.prefix' => env('CACHE_PREFIX', 'laravel'),

            'database.connections.mysql.collation' => 'utf8mb4_general_ci',
            'database.connections.mysql.modes' => [
                'ONLY_FULL_GROUP_BY',
                // 'STRICT_TRANS_TABLES',
                'NO_ZERO_IN_DATE',
                'NO_ZERO_DATE',
                'ERROR_FOR_DIVISION_BY_ZERO',
                'NO_AUTO_CREATE_USER',
                'NO_ENGINE_SUBSTITUTION',
            ],
            'database.redis.default.database' => 1,
            'database.redis.sessions' => [
                'host' => env('REDIS_HOST', '127.0.0.1'),
                'password' => env('REDIS_PASSWORD', null),
                'port' => env('REDIS_PORT', 6379),
                'database' => 2,
            ],

            'filesystems.disks.public.url' => env('APP_URL_ASSET', env('APP_URL')).'/storage',

            'session.connection' => 'sessions',
        ],

        'admin' => [
            'auth.defaults' => [
                'guard' => 'admin',
                'passwords' => 'admin_users',
            ],
            'session.domain' => env('SESSION_DOMAIN_ADMIN', null),
        ],

        'api' => [
            'session.domain' => env('SESSION_DOMAIN_API', null),
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
    | See `Agent\Client::getAppClientAttributes()` and
    | `Support\Providers\AppServiceProvider::fakeAppClient()`.
    |
    */

    'fake_app_client' => [
        'os' => 'iOS',
        'osV' => '9.3.3',
        'pf' => 'iPhone7,1',
        'loc' => 'zh_CN',
        'app' => 'FakeAppClient',
        'appV' => '1.0.0',
        'appC' => 'App Store',
        'net' => 'WiFi',
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
    | id : 'UA-XXXX-Y'
    | cookie_domain : 'auto' // 'none' // 'example.com'
    |
    */

    'google_analytics' => [
        'id' => env('GOOGLE_ANALYTICS_ID'),
        'cookie_domain' => env('GOOGLE_ANALYTICS_COOKIE_DOMAIN', 'auto'),
    ],

];
