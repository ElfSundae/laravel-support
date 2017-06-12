<?php

if (! function_exists('urlsafe_base64_encode')) {
    /**
     * Encodes the given data with base64, and returns an URL-safe string.
     *
     * @param  string  $data
     * @return string
     */
    function urlsafe_base64_encode($data)
    {
        return strtr(base64_encode($data), ['+' => '-', '/' => '_', '=' => '']);
    }
}

if (! function_exists('urlsafe_base64_decode')) {
    /**
     * Decodes a base64 encoded data.
     *
     * @param  string  $data
     * @param  bool  $strict
     * @return string
     */
    function urlsafe_base64_decode($data, $strict = false)
    {
        return base64_decode(strtr($data.str_repeat('=', (4 - strlen($data) % 4)), '-_', '+/'), $strict);
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
     * Converts any type to a string.
     *
     * @param  mixed  $value
     * @param  int  $jsonOptions  JSON_PRETTY_PRINT, etc
     * @return string
     */
    function string_value($value, $jsonOptions = 0)
    {
        if (is_object($value)) {
            if (method_exists($value, '__toString')) {
                return (string) $value;
            }

            if (method_exists($value, 'toArray')) {
                $value = $value->toArray();
            }
        }

        return is_string($value) ? $value : json_encode($value, $jsonOptions | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}

if (! function_exists('active')) {
    /**
     * Returns string 'active' if the current request URI matches the given patterns.
     *
     * @return string
     */
    function active()
    {
        return call_user_func_array([app('request'), 'is'], func_get_args()) ? 'active' : '';
    }
}
