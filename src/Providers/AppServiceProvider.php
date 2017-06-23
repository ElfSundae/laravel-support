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
        Helper::addAcceptableJsonType(
            function (Request $request) {
                return $this->shouldAddAcceptableJsonType($request);
            }
        );
    }

    /**
     * Determines appending JSON type to the "Accept" header for the current request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function shouldAddAcceptableJsonType(Request $request)
    {
        return is_app('api');
    }
}
