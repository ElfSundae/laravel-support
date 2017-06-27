<?php

namespace ElfSundae\Laravel\Support\Traits;

trait EnumKeyString
{
    /**
     * Returns the enum key (i.e. the constant name).
     *
     * @return mixed
     */
    abstract public function getKey();

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
