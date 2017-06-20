<?php

namespace ElfSundae\Laravel\Support\Services\Optimus;

use Jenssegers\Optimus\Optimus;
use Illuminate\Support\ServiceProvider;

class OptimusServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('optimus', function ($app) {
            $config = $app['config']->get('support.optimus');

            return new Optimus($config['prime'], $config['inverse'], $config['random']);
        });

        $this->app->alias('optimus', Optimus::class);

        if ($this->app->runningInConsole()) {
            $this->commands(GenerateOptimusCommand::class);
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['optimus', Optimus::class];
    }
}
