<?php

namespace ElfSundae\Laravel\Support;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\ServiceProvider;

class SupportServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'support');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/support.php' => config_path('support.php'),
            ], 'laravel-support-config');

            $this->publishes(
                [__DIR__.'/../resources/lang' => resource_path('lang')],
                'laravel-support-lang'
            );

            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/support'),
            ], 'laravel-support-views');
        }
    }

    /**
     * Register the application service.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/support.php', 'support');

        $this->setupConfiguration();

        if ($this->app->runningInConsole()) {
            $this->commands([
                Console\IdeHelperGenerateCommand::class,
            ]);
        }
    }

    /**
     * Setup application configurations.
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
     * Configure application for the current request.
     *
     * @return void
     */
    protected function configureForCurrentRequest()
    {
        if (
            ($identifier = $this->getCurrentAppIdentifier()) &&
            $config = $this->app['config']['support.config.'.$identifier]
        ) {
            $this->app['config']->set($config);
        }

        if ($carbonLocale = $this->app['config']['support.carbon_locale']) {
            Carbon::setLocale($carbonLocale);
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
}
