<?php

namespace ElfSundae\Laravel\Support\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

class EncryptCookies extends Middleware
{
    /**
     * The names of the cookies that should be encrypted.
     *
     * @var array
     */
    protected $only = [];

    /**
     * Enable encryption for the given cookie name(s).
     *
     * @param string|array $cookieName
     * @return void
     */
    public function enableFor($cookieName)
    {
        $this->only = array_merge($this->only, (array) $cookieName);
    }

    /**
     * Determine whether encryption has been disabled for the given cookie.
     *
     * @param  string $name
     * @return bool
     */
    public function isDisabled($name)
    {
        return ! in_array($name, $this->only);
    }
}
