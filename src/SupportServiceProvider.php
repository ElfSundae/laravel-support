<?php

namespace ElfSundae\Support;

use Carbon\Carbon;
use ReflectionClass;
use Illuminate\Console\Command;
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

        if ($this->app->runningInConsole()) {
            $this->registerCommands();
        }
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function registerCommands()
    {
        $commands = collect($this->app['files']->files(__DIR__.'/Console'))
            ->map(function ($fileInfo) {
                return __NAMESPACE__.'\\Console\\'.$fileInfo->getBasename('.php');
            })
            ->filter(function ($command) {
                return is_subclass_of($command, Command::class)
                    && ! (new ReflectionClass($command))->isAbstract();
            })
            ->all();

        if ($commands) {
            $this->commands($commands);
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
