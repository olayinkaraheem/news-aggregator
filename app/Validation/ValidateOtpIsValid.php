<?php

namespace App\Validation;

class ValidateOtpIsValid
{
    public function handle(array $data, \Closure $next = null)
    {
        $data['otp']->isValid($data['code']) ?: $data['validator']->errors()->add(
            'otp',
            __('validation.invalid_otp')
        );

        return $next ? $next($data) : true;
    }
}
