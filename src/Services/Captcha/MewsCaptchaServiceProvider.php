<?php

namespace ElfSundae\Laravel\Support\Services\Captcha;

use Mews\Captcha\CaptchaServiceProvider as ServiceProvider;

class MewsCaptchaServiceProvider extends ServiceProvider
{
    /**
     * Override the original Captcha service provider to
     * remove the default routing.
     */
    public function boot()
    {
        $this->publishes([
            base_path('vendor/mews/captcha/config/captcha.php') => config_path('captcha.php'),
        ], 'config');

        $this->app['validator']->extend('captcha', function ($attribute, $value) {
            return captcha_check($value);
        });
    }
}
