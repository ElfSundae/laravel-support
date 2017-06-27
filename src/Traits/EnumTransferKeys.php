<?php

namespace ElfSundae\Laravel\Support\Traits;

/**
 * Transfer keys for `MyCLabs\Enum\Enum`.
 *
 * Define the property `static $transferKeys = []` in your class to
 * provide transferred keys.
 */
trait EnumTransferKeys
{
    /**
     * Return key for value.
     *
     * @param $value
     * @return mixed
     */
    public static function search($value)
    {
        return static::getTransferredKey(parent::search($value));
    }

    /**
     * Get the transferred key for the given key.
     *
     * @param  mixed  $key
     * @return mixed
     */
    protected static function getTransferredKey($key)
    {
        if (
            property_exists(get_called_class(), 'transferKeys') &&
            is_array(static::$transferKeys) &&
            isset(static::$transferKeys[$key])
        ) {
            return static::$transferKeys[$key];
        }

        return $key;
    }
}
