<?php

namespace ElfSundae\Laravel\Support\Services\Optimus;

use Closure;
use Jenssegers\Optimus\Optimus;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OptimusServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->extendRouter();
    }

    /**
     * Register `modelWithOptimusHashid` router macro.
     *
     * @return void
     */
    protected function extendRouter()
    {
        $router = $this->app->make('router');

        $router->macro('modelWithOptimusHashid',
            function ($key, $class, Closure $callback = null) use ($router) {
                $router->bind($key, function ($value) use ($router, $class, $callback) {
                    if (is_null($value)) {
                        return;
                    }

                    $instance = $router->container->make($class);

                    if ($model = $instance->where($instance->getRouteKeyName(), $instance->getKeyForHashid($value))->first()) {
                        return $model;
                    }

                    if ($callback instanceof Closure) {
                        return call_user_func($callback, $value);
                    }

                    throw (new ModelNotFoundException)->setModel($class);
                });
            }
        );
    }

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
