<?php

namespace ElfSundae\Laravel\Support\Traits\Eloquent;

trait FreshCreatedAt
{
    /**
     * Set the value of the "created at" attribute.
     *
     * @param  mixed  $value
     * @return $this
     */
    abstract public function setCreatedAt($value);

    /**
     * Get a fresh timestamp for the model.
     *
     * @return \Carbon\Carbon
     */
    abstract public function freshTimestamp();

    /**
     * Boot the trait.
     *
     * Add a creating observer, set the value of the "created at" attribute.
     */
    protected static function bootFreshCreatedAt()
    {
        static::creating(function ($model) {
            $model->setCreatedAt($model->freshTimestamp());
        });
    }
}
