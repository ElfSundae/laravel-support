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
        $this->app->register(\ElfSundae\Laravel\Api\ApiServiceProvider::class);
        $this->app->register(\Intervention\Image\ImageServiceProviderLaravel5::class);
        $this->app->register(\NotificationChannels\BearyChat\BearyChatServiceProvider::class);
        $this->app->register(\SimpleSoftwareIO\QrCode\QrCodeServiceProvider::class);
        $this->app->register(\Vinkla\Hashids\HashidsServiceProvider::class);
        $this->app->register(\Yajra\Datatables\DatatablesServiceProvider::class);
        $this->app->register(\Yajra\Datatables\ButtonsServiceProvider::class);
        $this->app->register(\ElfSundae\Laravel\Support\Datatables\DatatablesServiceProvider::class);
        $this->app->register(Providers\AppConfigServiceProvider::class);
        $this->app->register(Providers\CaptchaServiceProvider::class);
        $this->app->register(Providers\ClientServiceProvider::class);
        $this->app->register(Providers\OptimusServiceProvider::class);
        $this->app->register(Providers\RoutingServiceProvider::class);
        $this->app->register(Providers\XgPusherServiceProvider::class);

        Helper::aliasFacade('Captcha', \Mews\Captcha\Facades\Captcha::class);
        Helper::aliasFacade('Image', \Intervention\Image\Facades\Image::class);
        Helper::aliasFacade('Qrcode', \SimpleSoftwareIO\QrCode\Facades\QrCode::class);
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
        $this->app->register(Providers\ConsoleServiceProvider::class);

        $this->publishes([
            __DIR__.'/../config/support.php' => config_path('support.php'),
        ], 'laravel-support');
    }
}
