<?php

use Ramsey\Uuid\Uuid;

if (! function_exists('is_app')) {
    /**
     * Check the current application identifier.
     *
     * @param  string  $identifier
     * @return bool
     */
    function is_app($identifier)
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

if (! function_exists('gravatar')) {
    /**
     * Generate a Gravatar url.
     *
     * @see http://cn.gravatar.com/site/implement/images/
     *
     * @param  string  $email
     * @param  int  $size
     * @param  string  $default
     * @param  string  $rating
     * @return string
     */
    function gravatar($email, $size = 100, $default = null, $rating = null)
    {
        if (is_null($default)) {
            $default = config('support.gravatar.default');
        }
        if (is_null($rating)) {
            $rating = config('support.gravatar.rating');
        }

        $query = http_build_query(array_filter(compact('size', 'default', 'rating')));

        return app('url')->assetFrom(
            config('support.gravatar.host', 'http://gravatar.com/avatar'),
            md5(strtolower(trim($email))).'?'.$query
        );
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
