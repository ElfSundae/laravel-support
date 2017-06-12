<?php

use GuzzleHttp\Client as HttpClient;

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

if (! function_exists('http_client')) {
    /**
     * Create a Guzzle http client.
     *
     * @param  array  $config
     * @return \GuzzleHttp\Client
     */
    function http_client($config = [])
    {
        return new HttpClient(
            array_merge([
                'connect_timeout' => 5,
                'timeout' => 25,
            ], $config)
        );
    }
}

if (! function_exists('fetch')) {
    /**
     * Request an URL.
     *
     * @param  string  $url
     * @param  string  $method
     * @param  array   $options
     * @return GuzzleHttp\Psr7\Response|null
     */
    function fetch($url, $method = 'GET', $options = [])
    {
        try {
            return http_client()->request($method, $url, $options);
        } catch (Exception $e) {
        }
    }
}

if (! function_exists('fetch_content')) {
    /**
     * Request an URL, and return the content.
     *
     * @param  string  $url
     * @param  string  $method
     * @param  array   $options
     * @param  GuzzleHttp\Psr7\Response|null  &$response
     * @return string
     */
    function fetch_content($url, $method = 'GET', $options = [], &$response = null)
    {
        if ($response = fetch($url, $method, $options)) {
            return (string) $response->getBody();
        }
    }
}

if (! function_exists('fetch_json')) {
    /**
     * Request an URL, and return the JSON data.
     *
     * @param  string  $url
     * @param  string  $method
     * @param  array   $options
     * @param  GuzzleHttp\Psr7\Response|null  &$response
     * @return mixed
     */
    function fetch_json($url, $method = 'GET', $options = [], &$response = null)
    {
        array_set($options, 'headers.Accept', 'application/json');

        return json_decode(fetch_content($url, $method, $options, $response), true);
    }
}

if (! function_exists('request')) {
    /**
     * Get an instance of the current request or an input item from the request.
     *
     * @param  array|string  $key
     * @param  mixed   $default
     * @return \Illuminate\Http\Request|string|array
     */
    function request($key = null, $default = null)
    {
        if (is_null($key)) {
            return app('request');
        }

        if (is_array($key)) {
            return app('request')->only($key);
        }

        return data_get(app('request')->all(), $key, $default);
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
