<?php

namespace ElfSundae\Support;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class SupportServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the service provider.
     *
     * @return void
     */
    public function boot()
    {
        Carbon::setLocale('zh');

        $this->registerCommands();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Console\IdeHelperGenerateCommand::class,
            ]);
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerSupport();
    }

    /**
     * Register support singleton.
     *
     * @return void
     */
    protected function registerSupport()
    {
        $this->app->singleton('support', function ($app) {
            return new Support($app);
        });

        $this->app->alias('support', Support::class);
    }
}
