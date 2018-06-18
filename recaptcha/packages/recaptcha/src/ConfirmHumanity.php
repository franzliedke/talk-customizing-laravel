<?php

namespace LaraLive\Recaptcha;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;
use ReCaptcha\ReCaptcha;

class ConfirmHumanity implements Rule
{
    private $captcha;
    private $request;

    /** @var \ReCaptcha\Response */
    private $validationResult;

    public function __construct(ReCaptcha $captcha, Request $request)
    {
        $this->captcha = $captcha;
        $this->request = $request;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $this->validationResult = $this->captcha
            ->verify($value, $this->request->getClientIp());

        return $this->validationResult->isSuccess();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        $codes = $this->validationResult->getErrorCodes();
        return 'ReCaptcha check failed: ' . implode(', ', $codes);
    }
}
