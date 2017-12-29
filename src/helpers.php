<?php

use Illuminate\Contracts\Support\Jsonable;

if (! function_exists('in_arrayi')) {
    /**
     * Case insensitive `in_array`.
     *
     * @see https://secure.php.net/manual/en/function.in-array.php#89256
     *
     * @param  string  $needle
     * @param  array  $haystack
     * @return bool
     */
    function in_arrayi($needle, $haystack)
    {
        return in_array(strtolower($needle), array_map('strtolower', $haystack));
    }
}

if (! function_exists('mb_trim')) {
    /**
     * Strip whitespace (or other characters) from the beginning and end of a string.
     *
     * @see https://github.com/vanderlee/PHP-multibyte-functions/blob/master/functions/mb_trim.php
     *
     * @param  string  $string
     * @return string
     */
    function mb_trim($string)
    {
        return mb_ereg_replace('^\s*([\s\S]*?)\s*$', '\1', $string);
    }
}

if (! function_exists('string_value')) {
    /**
     * Convert any type to a string.
     *
     * @param  mixed  $value
     * @param  int  $jsonOptions
     * @return string
     */
    function string_value($value, $jsonOptions = 0)
    {
        $jsonOptions |= JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES;

        if (is_string($value)) {
            return $value;
        } elseif ($value instanceof Jsonable) {
            return $value->toJson($jsonOptions);
        } elseif (method_exists($value, 'toArray')) {
            $value = $value->toArray();
        } elseif ($value instanceof Traversable) {
            $value = iterator_to_array($value);
        } elseif (method_exists($value, '__toString')) {
            return (string) $value;
        }

        return json_encode($value, $jsonOptions);
    }
}

if (! function_exists('active')) {
    /**
     * Return "active" if the current request URI matches the given patterns.
     *
     * @param  dynamic  $patterns
     * @return string
     */
    function active(...$patterns)
    {
        return request()->is(...$patterns) ? 'active' : '';
    }
}
