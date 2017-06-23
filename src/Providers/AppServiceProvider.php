<?php

namespace ElfSundae\Laravel\Support\Providers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use ElfSundae\Laravel\Support\Helper;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->setLocaleForCarbon();
    }

    /**
     * Set locale for Carbon.
     *
     * @return bool
     */
    protected function setLocaleForCarbon()
    {
        return Carbon::setLocale($this->app['config']->get('support.carbon_locale'), $this->app->getLocale());
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        array_map([$this->app, 'register'], $this->getServiceProviders());

        $this->modifyCurrentRequest();
    }

    /**
     * Get service providers to be registered.
     *
     * @return array
     */
    protected function getServiceProviders()
    {
        $providers = [];

        if (is_app('admin') || $this->app->runningInConsole()) {
            array_push(
                $providers,
                \ElfSundae\Laravel\Datatables\DatatablesServiceProvider::class,
                \Rap2hpoutre\LaravelLogViewer\LaravelLogViewerServiceProvider::class
            );
        }

        return $providers;
    }

    /**
     * Modify the current request.
     *
     * @return void
     */
    protected function modifyCurrentRequest()
    {
        Helper::addAcceptableJsonType(function (Request $request) {
            return $this->shouldAddAcceptableJsonType($request);
        });

        if ($this->shouldFakeAppClient()) {
            $this->fakeAppClient();
        }
    }

    /**
     * Determines appending JSON type to the "Accept" header for the current request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function shouldAddAcceptableJsonType(Request $request)
    {
        return $this->isApiRequest();
    }

    /**
     * Indicates the current request is an API request, e.g. the request is sent
     * from an API client.
     *
     * @return bool
     */
    protected function isApiRequest()
    {
        return is_app('api');
    }

    /**
     * Determines making a fake API client for the current request.
     *
     * @return bool
     */
    protected function shouldFakeAppClient()
    {
        return $this->app['config']->get('app.debug') &&
            $this->app->isLocal() &&
            $this->app['request']->ip() === '127.0.0.1' &&
            $this->isApiRequest();
    }

    /**
     * Fake current agent client as an app client.
     *
     * @return void
     */
    protected function fakeAppClient()
    {
        $this->app->resolving('agent.client', function ($client) {
            if (! $client->is('AppClient')) {
                $client->setUserAgent($this->getUserAgentForFakeAppClient());
            }
        });
    }

    /**
     * Get User-Agent string for fake app client.
     *
     * @return string
     */
    protected function getUserAgentForFakeAppClient()
    {
        $clientData = urlsafe_base64_encode(json_encode(
            $this->app['config']->get('support.fake_app_client', [])
        ));

        $userAgent = $this->app['request']->header('User-Agent');

        return "$userAgent client({$clientData})";
    }
}
