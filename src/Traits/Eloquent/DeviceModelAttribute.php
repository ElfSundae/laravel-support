<?php

namespace ElfSundae\Support\Traits\Eloquent;

use ElfSundae\Support\Facades\Support;

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
