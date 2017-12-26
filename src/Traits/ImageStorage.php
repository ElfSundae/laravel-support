<?php

namespace ElfSundae\Support\Traits;

use Exception;
use ElfSundae\Image\Filters\Resize;
use ElfSundae\Support\Facades\Support;
use Symfony\Component\HttpFoundation\File\UploadedFile;

trait ImageStorage
{
    use AssetHelper;

    /**
     * Store image file.
     *
     * @param  mixed  $file
     * @param  string|null  $identifier
     * @return string|null  The stored path
     */
    protected function storeImageFile($file, $identifier = null)
    {
        if ($file instanceof UploadedFile && ! $file->isValid()) {
            return;
        }

        try {
            $image = app('image')->make($file)
                ->filter($this->getImageFilter($identifier))
                ->encode(
                    $this->getImageEncodingFormat($identifier),
                    $this->getImageEncodingQuality($identifier)
                );
        } catch (Exception $e) {
            return;
        }

        $path = trim(trim($this->getImageDirectory($identifier), '/').'/'.trim($this->getImageFilename($image, $identifier), '/'), '/');

        if ($path && $this->getFilesystem($identifier)->put($path, $image)) {
            return $path;
        }
    }

    /**
     * Get image filter.
     *
     * @see http://image.intervention.io/api/filter
     *
     * @param  string|null  $identifier
     */
    protected function getImageFilter($identifier = null)
    {
        return (new Resize)->width(1024);
    }

    /**
     * Get image encoding format.
     *
     * @see http://image.intervention.io/api/encode
     *
     * @param  string|null  $identifier
     * @return string|null
     */
    protected function getImageEncodingFormat($identifier = null)
    {
    }

    /**
     * Get image encoding quality.
     *
     * @see http://image.intervention.io/api/encode
     *
     * @param  string|null  $identifier
     * @return int
     */
    protected function getImageEncodingQuality($identifier = null)
    {
        return 90;
    }

    /**
     * Get image output directory.
     *
     * @param  string|null  $identifier
     * @return string
     */
    protected function getImageDirectory($identifier = null)
    {
        return 'images/'.$this->getImageNestedDirectory($identifier);
    }

    /**
     * Get a "nested" image directory.
     *
     * @param  string|null  $identifier
     * @return string|null
     */
    protected function getImageNestedDirectory($identifier = null)
    {
        return dechex((int) date('Y') - 2000).'/'.dechex((int) date('W'));
    }

    /**
     * Get image output filename.
     *
     * @param  \Intervention\Image\Image  $image
     * @param  string|null  $identifier
     * @return string
     */
    protected function getImageFilename($image, $identifier = null)
    {
        return md5($image).Support::extension($image, '.');
    }
}
