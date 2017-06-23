<?php

namespace ElfSundae\Laravel\Support\Traits\Eloquent;

use ElfSundae\Laravel\Support\Constants\Sex;

trait SexAttribute
{
    /**
     * Get the 'sex' attribute.
     *
     * @param  int  $value
     * @return string|null
     */
    public function getSexAttribute($value)
    {
        return Sex::string($value);
    }

    /**
     * Set the 'sex' attribute.
     *
     * @param  mixed  $value
     */
    public function setSexAttribute($value)
    {
        $this->attributes['sex'] = Sex::type($value);
    }
}
