<?php

namespace App\Actions;

use App\Models\Otp;
use App\Helpers\Model\OtpHelper;

class CreateOtpAction
{
    public function handle(array $data, \Closure $next = null)
    {
        $otpHelper = new OtpHelper();
        
        $code = $otpHelper->generateCode();

        $otp = Otp::create([
            'user_id'       => $data['user']->id,
            'code'          => $code['hashed'],
            'expired_at'    => $otpHelper->getExpiredAt()
        ]);

        $data['code'] = $code['plain_text'];
        
        $data['otp'] = $otp;

        return $next ? $next($data) : true;
    }
}
