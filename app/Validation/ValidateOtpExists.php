<?php

namespace App\Validation;

class ValidateOtpExists
{
    public function handle(array $data, \Closure $next = null)
    {
        if (!$data['otp']->exist()) {
            return $data['validator']->errors()->add(
                'otp',
                __('validation.otp_not_found')
            );
        }

        return $next ? $next($data) : true;
    }
}
