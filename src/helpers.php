<?php

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
