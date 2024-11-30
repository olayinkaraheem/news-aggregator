<?php

namespace App\Actions;

use App\Notifications\EmailVerificationOtpNotification;

class SendEmailVerificationOtpAction
{
  public function handle(array $data, \Closure $next = null)
  {
    $user = $data['user'];

    $otp = $data['otp'];

    $data['expiresAt'] = $otp->expired_at->toDayDateTimeString();
    
    $user->notify(new EmailVerificationOtpNotification($data));

    return $next ? $next($data) : true;
  }
}