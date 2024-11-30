<?php

return [
    'max_send_count'    => env('OTP_MAX_SEND_COUNT', 3),
    'expired_in_the_next_minutes' => env('OTP_EXPIRED_IN_THE_NEXT_MINUTES', 3),
    'default_otp' => env('DEFAULT_OTP', '123456')
];