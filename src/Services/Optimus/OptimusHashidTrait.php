<?php

namespace ElfSundae\Laravel\Support\Services\Optimus;

trait OptimusHashidTrait
{
    /**
     * Get the value of the model's primary key.
     *
     * @return mixed
     */
    abstract public function getKey();

    /**
     * Get the table qualified key name.
     *
     * @return string
     */
    abstract public function getQualifiedKeyName();

    /**
     * Get the hashid for the given key.
     *
     * @param  mixed  $key
     * @return mixed
     */
    public function getHashidForKey($key)
    {
        $key = (int) $key;

        if ($key > 0) {
            return optimus_encode($key);
        }
    }

    /**
     * Get the key for the given hashid.
     *
     * @param  mixed  $hashid
     * @return mixed
     */
    public function getKeyForHashid($hashid)
    {
        $hashid = (int) $hashid;

        if ($hashid > 0) {
            return optimus_decode($hashid);
        }
    }

    /**
     * Get the `hashid` attribute.
     *
     * @return int
     */
    public function getHashidAttribute()
    {
        return $this->getHashidForKey($this->getKey());
    }

    /**
     * Scope a query to user of given hashid.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $hashid
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWhereHashid($query, $hashid)
    {
        return $query->where($this->getQualifiedKeyName(), $this->getKeyForHashid($hashid));
    }
}
