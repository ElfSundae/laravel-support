<?php

namespace ElfSundae\Laravel\Support\Providers;

use ElfSundae\Laravel\Support\Console\Commands;
use Illuminate\Support\ServiceProvider;

class ConsoleServiceProvider extends ServiceProvider
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
        $this->commands([
            Commands\AssetsVersion::class,
            Commands\IdeHelperGenerator::class,
            Commands\Int2stringCharacters::class,
        ]);
    }
}
