<?php

namespace ElfSundae\Laravel\Support\Traits;

trait EnumKeyString
{
    /**
     * To string.
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getKey();
    }
}
