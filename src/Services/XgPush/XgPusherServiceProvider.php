<?php

namespace ElfSundae\Laravel\Support\Services\XgPush;

use Illuminate\Support\ServiceProvider;

class XgPusherServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->singleton(XgPusher::class, function ($app) {
            $config = $app['config']['support.xgpush'];

            return (new XgPusher($config['key'], $config['secret']))
                ->setEnvironment($config['environment'])
                ->setCustomKey($config['custom_key'])
                ->setAccountPrefix($config['account_prefix']);
        });

        $this->app->alias(XgPusher::class, 'xgpusher');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            XgPusher::class,
            'xgpusher',
        ];
    }
}
