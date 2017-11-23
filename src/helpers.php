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
     * @param  string  $identifier
     * @param  mixed  $query
     * @return string
     */
    function app_url($path = '', $identifier = '', $query = [])
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

        $root = config('support.url.'.$identifier, config('app.url'));

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
            asset_path($path)
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
