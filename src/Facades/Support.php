<?php

namespace ElfSundae\Support\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string|null extension(mixed $file, string $prefix = '')
 * @method static string|null extensionForMime(string $mimeType)
 * @method static string iDeviceModel(string $platform)
 * @method static string|null emailHome(string $email)
 * @method static void fakeAppClient(array $client)
 * @method static void fakeApiToken(string $appKey = null)
 *
 * @see \ElfSundae\Support\Support
 */
class Support extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'support';
    }
}
