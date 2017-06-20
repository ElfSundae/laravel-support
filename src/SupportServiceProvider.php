<?php

namespace ElfSundae\Laravel\Support;

use Illuminate\Support\ServiceProvider;

class SupportServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/support.php', 'support');

        $this->setupConfiguration();

        array_map([$this->app, 'register'], $this->getServiceProviders());

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/support.php' => config_path('support.php'),
            ], 'laravel-support');

            $this->registerForConsole();
        }
    }

    /**
     * Setup app configuration.
     *
     * @return void
     */
    protected function setupConfiguration()
    {
        if (! $this->app->configurationIsCached()) {
            $this->configureDefaults();
        }

        $this->configureForCurrentRequest();
    }

    /**
     * Configure app defaults.
     *
     * @return void
     */
    protected function configureDefaults()
    {
        $config = $this->app['config'];

        // Append "app.domains"
        $config['app.domains'] = array_map(function ($value) {
            if (is_string($domain = parse_url($value, PHP_URL_HOST))) {
                if (str_contains($domain, '.')) {
                    return $domain;
                }
            }
        }, $config['support.url']);

        // Set "mail.from.name"
        if ($config['mail.from.name'] == 'Example') {
            $config['mail.from.name'] = $config['app.name'];
        }
    }

    /**
     * Configure app for the current request.
     *
     * @return void
     */
    protected function configureForCurrentRequest()
    {
        $config = $this->app['config'];
        $request = $this->app['request'];

        $identifier = array_search($request->getHost(), $config['app.domains']);

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
        $providers = [
            Providers\RoutingServiceProvider::class,
        ];

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
        ]);
    }
}
