<?php

namespace LaraLive\Recaptcha;

use Illuminate\Contracts\Validation\Factory;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;
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
        $this->app->make(BladeCompiler::class)->directive(
            'recaptcha',
            function () {
                $key = $this->app['config']['services.recaptcha.key'];
                return <<<HTML
<script type="text/javascript" src="https://www.google.com/recaptcha/api.js?hl=en"></script>
<div class="g-recaptcha" data-sitekey="$key"></div>
HTML;
            }
        );

        $this->app->make(Factory::class)->extendImplicit(
            'human',
            function ($attribute, $value) {
                $captcha = $this->app->make(ReCaptcha::class);
                $request = $this->app->make('request');

                return $captcha->verify($value, $request->getClientIp())->isSuccess();
            },
            'Please confirm you are human.'
        );
    }
}
