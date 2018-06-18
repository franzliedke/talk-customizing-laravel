<?php

namespace LaraLive\Recaptcha;

use Illuminate\Support\ServiceProvider;
use ReCaptcha\ReCaptcha;

class RecaptchaServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            ReCaptcha::class,
            function ($app) {
                $secret = $app['config']['services.recaptcha.secret'];
                return new ReCaptcha($secret);
            }
        );
    }

    public function boot()
    {
        //
    }
}
