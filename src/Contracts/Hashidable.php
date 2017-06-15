<?php

namespace ElfSundae\Laravel\Support\Contracts;

interface Hashidable
{
    /**
     * Get the hashid for the given key.
     *
     * @param  mixed  $key
     * @return mixed
     */
    public function getHashidForKey($key);

    /**
     * Get the key for the given hashid.
     *
     * @param  mixed  $hashid
     * @return mixed
     */
    public function getKeyForHashid($hashid);
}
