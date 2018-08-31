# Customizing Laravel

Material to go along with my "Customizing Laravel" talks (LaravelLiveUK 2018 / Laracon EU 2018)

This sums up the steps I did during my live coding demos, carefully described with lengthy Git commits.

## Buidling a Laravel package for ReCaptcha

[**Walk through the live coding**](https://github.com/franzliedke/talk-customizing-laravel/commits/master/recaptcha)

The goal: Making ReCaptcha feel like part of the framework, with perfect integration into Blade and the validation component.
In the end, all you will need to do to integrate a captcha into a form is this:

~~~html
<form>
  <div class="field">
    @recaptcha
  </div>
</form>
~~~

And on the server side, for validation:

~~~php
Validator::make(data, [
  'g-recaptcha-response' => 'human',
]);
~~~
