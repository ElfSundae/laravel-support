<?php

namespace ElfSundae\Laravel\Support;

use Illuminate\Support\ServiceProvider;

class SupportServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'support');

        $this->publishes([
            __DIR__.'/../config/support.php' => config_path('support.php'),
        ], 'laravel-support');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/support'),
        ], 'laravel-support-views');
    }

    /**
     * Register the service.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/support.php', 'support');

        $this->setupConfigurations();

        array_map([$this->app, 'register'], $this->getServiceProviders());

        if ($this->app->runningInConsole()) {
            $this->registerForConsole();
        }
    }

    /**
     * Setup application configurations.
     *
     * @return void
     */
    protected function setupConfigurations()
    {
        if (! $this->app->configurationIsCached()) {
            $this->configureDefaults();
        }

        $this->configureForCurrentRequest();
    }

    /**
     * Configure application defaults.
     *
     * @return void
     */
    protected function configureDefaults()
    {
        $config = $this->app['config'];

        $config['support.domain'] = array_map(function ($value) {
            return parse_url($value, PHP_URL_HOST) ?: null;
        }, $config->get('support.url', []));

        // Illuminate\Database\DatabaseServiceProvider reads "app.faker_locale" config
        $config['app.faker_locale'] = $config['support.faker_locale'];

        $config['cache.prefix'] = $config('support.cache_key_prefix');
    }

    /**
     * Merge config data for the given key.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return void
     */
    protected function mergeConfigForKey($key, $value)
    {
        $config = $this->app['config']->get($key);

        if (is_array($config) && is_array($value)) {
            $config = array_merge($config, $value);
        } else {
            $config = $value;
        }

        $this->app['config']->set($key, $config);
    }

    /**
     * Configure application for the current request.
     *
     * @return void
     */
    protected function configureForCurrentRequest()
    {
        $config = $this->app['config'];
        $request = $this->app['request'];

        $identifier = array_search($request->getHost(), $config['support.domain']);

        if ($identifier && $config->has('support.cookie_domain.'.$identifier)) {
            $config['session.domain'] = $config['support.cookie_domain.'.$identifier];
        }

        if ($identifier && is_array($auth = $config['support.auth.'.$identifier])) {
            $config['auth.defaults'] = $auth;
        }
    }

    /**
     * Get service providers to be registered.
     *
     * @return array
     */
    protected function getServiceProviders()
    {
        $providers = [];

        if ($this->app->isLocal()) {
            array_push(
                $providers,
                \Barryvdh\Debugbar\ServiceProvider::class
            );

            if ($this->app->runningInConsole()) {
                array_push(
                    $providers,
                    \Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class
                );
            }
        }

        if ($this->app->runningInConsole()) {
            array_push(
                $providers,
                \Laravel\Tinker\TinkerServiceProvider::class,
                \Spatie\Backup\BackupServiceProvider::class
            );
        }

        return $providers;
    }

    /**
     * Register for console.
     *
     * @return void
     */
    protected function registerForConsole()
    {
        $this->commands([
            Console\Commands\AssetsVersion::class,
            Console\Commands\GenerateIdeHelpers::class,
            Console\Commands\GenerateInt2stringCharacters::class,
            Console\Commands\MergeUpstream::class,
        ]);
    }
}
