<?php

namespace ElfSundae\Laravel\Support\Providers;

use Closure;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RoutingServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        $this->extendRouter();
    }

    /**
     * Extend router.
     */
    public function extendRouter()
    {
        $router = $this->app->make('router');

        $router->macro(
            'modelWithHashid',
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
}
