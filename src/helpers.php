<?php

use Ramsey\Uuid\Uuid;

if (! function_exists('revision')) {
    /**
     * Get the revisioned asset path.
     *
     * @param  string  $path
     * @return string
     */
    function revision($path)
    {
        if ($rev = array_get(config('assets-version'), trim($path, '/'))) {
            return $path.'?'.$rev;
        }

        return $path;
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

if (! function_exists('gravatar')) {
    /**
     * Generate a Gravatar url.
     *
     * @see https://en.gravatar.com/site/implement/images/
     *
     * @param  string  $email
     * @param  int  $size
     * @param  string  $default
     * @param  string  $rating
     * @return string
     */
    function gravatar($email, $size = 120, $default = null, $rating = null)
    {
        if (is_null($default)) {
            $default = config('support.gravatar.default');
        }

        if (is_null($rating)) {
            $rating = config('support.gravatar.rating');
        }

        $query = http_build_query(array_filter(compact('size', 'default', 'rating')));
        if ($query) {
            $query = '?'.$query;
        }

        return app('url')->assetFrom(
            config('support.gravatar.host', 'https://www.gravatar.com/avatar'),
            md5(strtolower(trim($email))).$query
        );
    }
}

if (! function_exists('is_app')) {
    /**
     * Determine the current sub application.
     *
     * @param  string  $identifier
     * @return bool
     */
    function is_app($identifier)
    {
        return ($appUrl = config('support.url.'.$identifier)) &&
            starts_with(
                preg_replace('#^https?://#', '', app('request')->url()),
                preg_replace('#^https?://#', '', $appUrl)
            );
    }
}

if (! function_exists('app_url')) {
    /**
     * Generate an absolute URL to the given path.
     *
     * @param  string  $path
     * @param  mixed  $query
     * @param  string  $identifier
     * @return string
     */
    function app_url($path = '', $query = [], $identifier = '')
    {
        $path = trim($path, '/');
        if (! empty($path)) {
            $path = '/'.$path;
        }

        if ($query) {
            $query = http_build_query($query);
            if (! empty($query)) {
                $path .= (str_contains($path, ['?', '&', '#']) ? '&' : '?').$query;
            }
        }

        $root = $identifier ? config('support.url.'.$identifier) : config('app.url');

        return $root.$path;
    }
}

if (! function_exists('asset_url')) {
    /**
     * Generate an asset URL to the given path.
     *
     * @param  string  $path
     * @return string
     */
    function asset_url($path, $identifier = 'asset')
    {
        return app('url')->assetFrom(
            config('support.url.'.$identifier),
            revision($path)
        );
    }
}

if (! function_exists('cdn_url')) {
    /**
     * Generate an asset CDN URL to the given path.
     *
     * @param  string  $path
     * @return string
     */
    function cdn_url($path)
    {
        return asset_url($path, 'cdn');
    }
}
