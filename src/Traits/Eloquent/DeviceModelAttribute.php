<?php

namespace ElfSundae\Laravel\Support\Traits\Eloquent;

use ElfSundae\Laravel\Support\Facades\Support;

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

        return Support::iDeviceModel($this->{$platform});
    }
}
