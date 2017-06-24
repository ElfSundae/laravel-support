<?php

namespace ElfSundae\Laravel\Support\Traits\Eloquent;

/**
 * Add ability for Eloquent to hide or visible attributes via static methods.
 */
trait AttributesVisibility
{
    /**
     * The shared attributes that should be hidden for serialization.
     *
     * @var array|null
     */
    public static $sharedHidden;

    /**
     * The shared attributes that should be visible in serialization.
     *
     * @var array|null
     */
    public static $sharedVisible;

    /**
     * Get the shared hidden attributes.
     *
     * @return array|null
     */
    public static function getSharedHidden()
    {
        return static::$sharedHidden;
    }

    /**
     * Set the shared hidden attributes.
     *
     * @param  array|null  $hidden
     * @return void
     */
    public static function setSharedHidden($hidden)
    {
        static::$sharedHidden = $hidden;
    }

    /**
     * Get the shared visible attributes.
     *
     * @return array|null
     */
    public static function getSharedVisible()
    {
        return static::$sharedVisible;
    }

    /**
     * Set the shared visible attributes.
     *
     * @param  array|null  $visible
     * @return void
     */
    public static function setSharedVisible($visible)
    {
        static::$sharedVisible = $visible;
    }

    /**
     * Make all attributes be visible.
     *
     * @return void
     */
    public static function makeAllVisible()
    {
        static::$sharedHidden = static::$sharedVisible = [];
    }

    /**
     * Restore attributes visibility.
     *
     * @return void
     */
    public static function restoreAttributesVisibility()
    {
        static::$sharedHidden = static::$sharedVisible = null;
    }

    /**
     * Get the hidden attributes for the model.
     *
     * @return array
     */
    public function getHidden()
    {
        if (is_array(static::$sharedHidden)) {
            return static::$sharedHidden;
        }

        return parent::getHidden();
    }

    /**
     * Get the visible attributes for the model.
     *
     * @return array
     */
    public function getVisible()
    {
        if (is_array(static::$sharedVisible)) {
            return static::$sharedVisible;
        }

        return parent::getVisible();
    }
}
