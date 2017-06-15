<?php

namespace ElfSundae\Laravel\Support\Constants;

class Sex
{
    const UNKNOWN = 0;
    const MALE = 1;
    const FEMALE = 2;

    /**
     * Convert a sex constants to string.
     *
     * @param  int  $sex
     * @return string|null
     */
    public static function string($sex)
    {
        if ($sex === static::MALE) {
            return '男';
        } elseif ($sex === static::FEMALE) {
            return '女';
        }
    }

    /**
     * Convert a sex string to int type.
     *
     * @param  mixed  $string
     * @return int
     */
    public static function type($sex)
    {
        if ($sex == '男') {
            return static::MALE;
        } elseif ($sex == '女') {
            return static::FEMALE;
        }

        return static::UNKNOWN;
    }

    /**
     * All sex types.
     *
     * @return int[]
     */
    public static function allTypes()
    {
        return [static::MALE, static::FEMALE];
    }
}
