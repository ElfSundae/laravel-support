<?php

use Ramsey\Uuid\Uuid;

if (! function_exists('get_id')) {
    /**
     * Get id from a mixed variable.
     *
     * @param  mixed  $var
     * @param  string  $key
     * @return mixed
     */
    function get_id($var, $key = 'id')
    {
        if (is_object($var)) {
            return $var->{$key};
        } elseif (is_array($var)) {
            return $var[$key];
        }

        return $var;
    }
}

if (! function_exists('is_domain')) {
    /**
     * Determines the current domain equals to the given domain identifier.
     *
     * @param  string  $identifier
     * @return bool
     */
    function is_domain($identifier)
    {
        return app('request')->getHost() === config('app.domains.'.$identifier);
    }
}

if (! function_exists('app_url')) {
    /**
     * Generate an URL for the application.
     *
     * @param  string  $path
     * @param  mixed  $parameters
     * @param  string  $identifier
     * @return string
     */
    function app_url($path = '', $parameters = null, $identifier = 'site')
    {
        $path = trim($path, '/');
        if (! empty($path) && ! starts_with($path, ['?', '&', '#'])) {
            $path = '/'.$path;
        }

        if (! is_null($parameters)) {
            $query = http_build_query($parameters);
            if (! empty($query)) {
                $path .= (str_contains($path, ['?', '&', '#']) ? '&' : '?').$query;
            }
        }

        if ($identifier && ($root = config('support.url.'.$identifier))) {
            return $root.$path;
        }

        return url($path);
    }
}

if (! function_exists('revision')) {
    /**
     * Get the revisioned asset path.
     *
     * @param  string  $path
     * @return string
     */
    function revision($path)
    {
        if ($rev = array_get(config('assets-version'), trim($path, DIRECTORY_SEPARATOR))) {
            return $path.'?'.$rev;
        }

        return $path;
    }
}

if (! function_exists('asset_from')) {
    /**
     * Generate the URL to an asset from a custom root domain such as CDN, etc.
     *
     * @param  string  $root
     * @param  string  $path
     * @param  bool|null  $secure
     * @return string
     */
    function asset_from($root, $path = '', $secure = null)
    {
        return app('url')->assetFrom($root, $path, $secure);
    }
}

if (! function_exists('asset_url')) {
    /**
     * Generate an asset URL.
     *
     * @param  string $path
     * @return string
     */
    function asset_url($path, $identifier = 'asset')
    {
        if (filter_var($path, FILTER_VALIDATE_URL) !== false) {
            return $path;
        }

        return config('support.url.'.$identifier).'/'.revision(trim($path, '/'));
    }
}

if (! function_exists('cdn_url')) {
    /**
     * Generate an asset CDN URL.
     *
     * @param  string  $path
     * @return string
     */
    function cdn_url($path)
    {
        return asset_url($path, 'cdn');
    }
}

if (! function_exists('optimus_encode')) {
    /**
     * Encode a number with Optimus.
     *
     * @param  int  $number
     * @return int
     */
    function optimus_encode($number)
    {
        return app('optimus')->encode($number);
    }
}

if (! function_exists('optimus_decode')) {
    /**
     * Decode a number with Optimus.
     *
     * @param  int  $number
     * @return int
     */
    function optimus_decode($number)
    {
        return app('optimus')->decode($number);
    }
}

if (! function_exists('random_uuid')) {
    /**
     * Generate a version 4 (random) UUID.
     *
     * @param  bool  $hex
     * @return string
     */
    function random_uuid($hex = false)
    {
        $uuid = Uuid::uuid4();

        return $hex ? $uuid->getHex() : $uuid->toString();
    }
}
