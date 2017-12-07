<?php

namespace ElfSundae\Laravel\Support;

use Carbon\Carbon;
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

            $this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang'),
            ], 'laravel-support-lang');

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
            if ($defaults = $this->app['config']['support.config.default']) {
                $this->app['config']->set($defaults);
            }
        }

        $this->configureForCurrentRequest();
    }

    /**
     * Configure application for the current request.
     *
     * @return void
     */
    protected function configureForCurrentRequest()
    {
        // if (app_id() && $appConfig = $this->app['config']->get('support.config.'.app_id())) {
        //     $this->app['config']->set($appConfig);
        // }

        if ($carbonLocale = $this->app['config']['support.carbon_locale']) {
            Carbon::setLocale($carbonLocale);
        }
    }
}
