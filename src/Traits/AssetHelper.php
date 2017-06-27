<?php

namespace ElfSundae\Laravel\Support\Traits;

use Illuminate\Support\Facades\Storage;

trait AssetHelper
{
    /**
     * Get Filesystem instance for the given identifier.
     *
     * @param  string|null  $identifier
     * @return \Illuminate\Contracts\Filesystem\Filesystem
     */
    public function getFilesystem($identifier = null)
    {
        return Storage::disk($this->getFilesystemDisk($identifier));
    }

    /**
     * Get asset URL.
     *
     * @param  string  $path
     * @param  string|null  $identifier
     * @return string|null
     */
    protected function getAssetUrl($path, $identifier = null)
    {
        return $this->getFilesystem($identifier)->url($path);
    }

    /**
     * Get disk name for filesystem.
     *
     * @param  string|null  $identifier
     * @return string|null
     */
    protected function getFilesystemDisk($identifier = null)
    {
        return 'public';
    }
}
