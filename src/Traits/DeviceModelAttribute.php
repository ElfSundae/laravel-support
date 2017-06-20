<?php

namespace ElfSundae\Laravel\Support\Traits;

use ElfSundae\Laravel\Support\Helper;

trait DeviceModelAttribute
{
    /**
     * Get the `device_model` attribute.
     *
     * @return string|null
     */
    public function getDeviceModelAttribute()
    {
        $platform = property_exists($this, 'deviceModelKey') ? $this->deviceModelKey : 'platform';

        return Helper::iDeviceModel($this->{$platform});
    }
}
