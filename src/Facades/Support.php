<?php

namespace ElfSundae\Laravel\Support\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \ElfSundae\Laravel\Support\Support
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
