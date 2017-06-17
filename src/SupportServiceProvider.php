<?php

namespace ElfSundae\Laravel\Support;

use Illuminate\Support\ServiceProvider;

class SupportServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/support.php', 'support');

        $this->registerServices();

        if ($this->app->isLocal()) {
            $this->registerForLocalEnvironment();
        }

        if ($this->app->runningInConsole()) {
            $this->registerForConsole();
        }
    }

    public function registerServices()
    {
        $this->app->register(Providers\ConfigServiceProvider::class);
        $this->app->register(\ElfSundae\Laravel\Agent\AgentServiceProvider::class);

        $this->app->register(\Intervention\Image\ImageServiceProviderLaravel5::class);
        $this->app->register(\NotificationChannels\BearyChat\BearyChatServiceProvider::class);
        $this->app->register(\SimpleSoftwareIO\QrCode\QrCodeServiceProvider::class);
        $this->app->register(\Vinkla\Hashids\HashidsServiceProvider::class);
        $this->app->register(\Yajra\Datatables\DatatablesServiceProvider::class);
        $this->app->register(\Yajra\Datatables\ButtonsServiceProvider::class);
        $this->app->register(Datatables\DatatablesServiceProvider::class);
        $this->app->register(Providers\RoutingServiceProvider::class);
    }

    public function registerForLocalEnvironment()
    {
        $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
    }

    /**
     * Register for console.
     *
     * @return void
     */
    protected function registerForConsole()
    {
        $this->app->register(\Laravel\Tinker\TinkerServiceProvider::class);
        $this->app->register(\Spatie\Backup\BackupServiceProvider::class);

        $this->publishes([
            __DIR__.'/../config/support.php' => config_path('support.php'),
        ], 'laravel-support');

        $this->commands([
            Console\Commands\AssetsVersion::class,
            Console\Commands\GenerateIdeHelpers::class,
            Console\Commands\GenerateInt2stringCharacters::class,
        ]);
    }
}
