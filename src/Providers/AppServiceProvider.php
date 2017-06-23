<?php

namespace ElfSundae\Laravel\Support\Providers;

use Carbon\Carbon;
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
}
