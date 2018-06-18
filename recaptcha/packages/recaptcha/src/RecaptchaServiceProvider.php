<?php

namespace LaraLive\Recaptcha;

use Illuminate\Support\Facades\Blade;
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
        Blade::directive(
            'recaptcha',
            function () {
                $key = $this->app['config']['services.recaptcha.key'];
                return <<<HTML
<script type="text/javascript" src="https://www.google.com/recaptcha/api.js?hl=en"></script>
<div class="g-recaptcha" data-sitekey="$key"></div>
HTML;
            }
        );
    }
}
