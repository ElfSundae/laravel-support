<?php

namespace ElfSundae\Laravel\Support;

use Illuminate\Support\Arr;
use MyCLabs\Enum\Enum as PhpEnum;
use ElfSundae\Laravel\Support\Traits\EnumDefaultKey;
use ElfSundae\Laravel\Support\Traits\EnumTransferKeys;

abstract class Enum extends PhpEnum
{
    use EnumTransferKeys, EnumDefaultKey;

    /**
     * Get the key for the given value.
     *
     * @param  mixed  $value
     * @return mixed
     */
    public static function key($value)
    {
        return static::search($value);
    }

    /**
     * Get the value for the given key.
     *
     * @param  mixed  $key
     * @return mixed
     */
    public static function value($key)
    {
        return Arr::get(
            static::toArray(),
            static::getOriginalKey($key),
            static::defaultValue()
        );
    }

    /**
     * Get all values.
     *
     * @return array
     */
    public static function allValues()
    {
        return array_values(static::toArray());
    }

    /**
     * Get all keys.
     *
     * @return array
     */
    public static function allKeys()
    {
        return array_map(function ($key) {
            return static::getTransferredKey($key);
        }, static::keys());
    }

    /**
     * Get the key for the given value.
     *
     * @param  mixed  $value
     * @return mixed
     */
    public static function search($value)
    {
        $key = parent::search($value);

        if ($key === false) {
            $key = static::defaultKey();
        }

        return static::getTransferredKey($key);
    }

    /**
     * Check if is valid enum key.
     *
     * @param  mixed  $key
     * @return bool
     */
    public static function isValidKey($key)
    {
        return parent::isValidKey(static::getOriginalKey($key));
    }

    /**
     * Returns a value when called statically like so:
     * MyEnum::SOME_VALUE() given SOME_VALUE is a class constant
     *
     * @param  string  $name
     * @param  array  $arguments
     * @return static
     */
    public static function __callStatic($name, $arguments)
    {
        return new static(static::value($name));
    }
}
