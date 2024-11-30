<?php

namespace App\Actions;

use App\Notifications\SendPasswordResetOtpNotification;

class SendPasswordResetOtpAction
{
  public function handle(array $data, \Closure $next = null)
  {
    $user = $data['user'];

    $otp = $data['otp'];

    $data['expiresAt'] = $otp->expired_at->toDayDateTimeString();
    
    $user->notify(new SendPasswordResetOtpNotification($data));

    return $next ? $next($data) : true;
  }
}