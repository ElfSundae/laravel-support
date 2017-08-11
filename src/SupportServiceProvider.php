<?php

namespace ElfSundae\Laravel\Support;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
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
            return parse_url($value, PHP_URL_HOST);
        }, $config->get('support.url', []));

        $config->set($config->get('support.config.default', []));
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
        $identifier = $this->getCurrentAppIdentifier();

        if ($identifier &&
            $config = $this->app['config']->get('support.config.'.$identifier)
        ) {
            $this->app['config']->set($config);
        }
    }

    /**
     * Get the current sub application identifier.
     *
     * @return string|null
     */
    protected function getCurrentAppIdentifier()
    {
        $requestUrl = $this->removeUrlScheme($this->app['request']->url());

        $apps = array_map(
            [$this, 'removeUrlScheme'],
            $this->app['config']->get('support.url', [])
        );
        arsort($apps);

        foreach ($apps as $id => $url) {
            if (Str::startsWith($requestUrl, $url)) {
                return $id;
            }
        }
    }

    /**
     * Remove the scheme for the given URL.
     *
     * @param  string  $url
     * @return string
     */
    protected function removeUrlScheme($url)
    {
        return preg_replace('#^https?://#', '', $url);
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
