<?php

namespace ElfSundae\Laravel\Support\Traits;

use Illuminate\Support\Arr;

/**
 * Define the default key/value for `MyCLabs\Enum\Enum`.
 *
 * If the property `static $defaultKey` does not exist, the first
 * constant will be used.
 */
trait EnumDefaultKey
{
    /**
     * Get the default key.
     *
     * @return string
     */
    public static function defaultKey()
    {
        if (property_exists(get_called_class(), 'defaultKey')) {
            return static::$defaultKey;
        }

        return Arr::first(array_keys(static::toArray()));
    }

    /**
     * Get the default value.
     *
     * @return mixed
     */
    public static function defaultValue()
    {
        return Arr::get(static::toArray(), static::defaultKey());
    }
}
