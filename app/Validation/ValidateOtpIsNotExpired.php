<?php

namespace App\Validation;

class ValidateOtpIsNotExpired
{
    public function handle(array $data, \Closure $next = null)
    {
        !$data['otp']->isExpired() ?: $data['validator']->errors()->add(
            'otp',
            __('validation.expired_otp')
        );

        return $next ? $next($data) : true;
    }
}
