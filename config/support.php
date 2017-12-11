<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Assets Application Identifier
    |--------------------------------------------------------------------------
    |
    | This application identifier determines the root URL for generating URL
    | to application assets.
    |
    */

    'assets_app' => env('ASSETS_APP', 'assets'),

    /*
    |--------------------------------------------------------------------------
    | Carbon Datetime Translator Locale
    |--------------------------------------------------------------------------
    |
    | All avaliable locales are located in
    | "vendor/nesbot/carbon/src/Carbon/Lang" directory.
    |
    */

    'carbon_locale' => 'zh',

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
            'apps.url.app' => env('APP_URL_APP', env('APP_URL')),

            'app.timezone' => 'Asia/Shanghai',
            'app.locale' => 'zh-CN',
            'app.faker_locale' => 'zh_CN',
            'app.log' => env('APP_LOG', 'daily'),

            'auth.guards.admin' => [
                'driver' => 'session',
                'provider' => 'admin_users',
            ],
            'auth.providers.users.model' => App\Models\User::class,
            'auth.providers.admin_users' => [
                'driver' => 'eloquent',
                'model' => App\Models\AdminUser::class,
            ],
            'auth.passwords.admin_users' => [
                'provider' => 'admin_users',
                'table' => 'admin_password_resets',
                'expire' => 60,
            ],

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

            'filesystems.disks.public.url' => env('APP_URL_ASSETS', env('APP_URL')).'/storage',

            'session.connection' => 'sessions',

            'services.gravatar' => [
                'url' => 'https://gravatar.cat.net/avatar',
                'size' => '120',
                'default' => 'identicon',
                'rating' => 'pg',
            ],

            'services.google_analytics' => [
                'id' => env('GOOGLE_ANALYTICS_ID'),
                // 'auto', 'none', 'example.com'
                'cookie_domain' => env('GOOGLE_ANALYTICS_COOKIE_DOMAIN', 'auto'),
            ],

            'services.mobsms' => [
                'key' => env('MOBSMS_KEY'),
            ],

            'services.xgpush' => [
                'key' => env('XGPUSH_KEY'),
                'secret' => env('XGPUSH_SECRET'),
                'environment' => env('XGPUSH_ENVIRONMENT', env('APP_ENV')),
                'custom_key' => 'my',
                'account_prefix' => 'user',
            ],

            'captcha.default' => [
                'length' => 4,
                'width' => 80,
                'height' => 32,
                'lines' => 0,
                'bgImage' => true,
                'fontColors' => ['#2c3e50', '#c0392b', '#16a085', '#c0392b', '#8e44ad', '#303f9f', '#f57c00', '#795548'],
            ],

            'datatables-html.table' => [
                'id' => 'dataTable',
                'class' => 'table table-bordered table-hover dt-responsive',
                'width' => '100%',
            ],
            'datatables-buttons.namespace.model' => 'Models',
            'datatables-buttons.parameters' => [
                'order' => [[0, 'desc']],
                'fixedHeader' => true,
            ],

            'debugbar.options.auth.show_name' => false,
            'debugbar.options.route.label' => false,

            'ide-helper.include_fluent' => true,
            'ide-helper.include_helpers' => true,
            'ide-helper.helper_files' => [
                base_path('vendor/laravel/framework/src/Illuminate/Support/helpers.php'),
                base_path('vendor/laravel/framework/src/Illuminate/Foundation/helpers.php'),
                base_path('app/helpers.php'),
                base_path('vendor/elfsundae/laravel-helper/src/helpers.php'),
                base_path('vendor/elfsundae/urlsafe-base64/src/helpers.php'),
                base_path('vendor/elfsundae/laravel-apps/src/helpers.php'),
                base_path('vendor/elfsundae/laravel-api/src/helpers.php'),
                base_path('vendor/elfsundae/laravel-gravatar/src/helpers.php'),
                base_path('vendor/elfsundae/laravel-hashid/src/helpers.php'),
                base_path('vendor/elfsundae/laravel-asset-version/src/helpers.php'),
                base_path('vendor/barryvdh/laravel-debugbar/src/helpers.php'),
            ],
            'ide-helper.custom_db_types' => [
                'mysql' => [
                    'json' => 'json_array',
                ],
            ],
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

];
