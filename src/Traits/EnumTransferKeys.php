<?php

namespace ElfSundae\Laravel\Support\Traits;

/**
 * Transfer keys for `MyCLabs\Enum\Enum`.
 *
 * protected static $transferKeys = [
 *     'original_key' => 'transferred_key',
 * ];
 */
trait EnumTransferKeys
{
    /**
     * Get the transfer keys.
     *
     * @return array
     */
    protected static function transferKeys()
    {
        if (
            property_exists(get_called_class(), 'transferKeys') &&
            is_array(static::$transferKeys)
        ) {
            return static::$transferKeys;
        }

        return [];
    }

    /**
     * Get the transferred key for the given key.
     *
     * @param  mixed  $key
     * @return mixed
     */
    protected static function getTransferredKey($key)
    {
        return static::transferKeys()[$key] ?? $key;
    }

    /**
     * Get the original key.
     *
     * @param  mixed  $key
     * @return mixed
     */
    protected static function getOriginalKey($key)
    {
        $originalKey = array_search($key, static::transferKeys(), true);

        return $originalKey !== false ? $originalKey : $key;
    }
}
