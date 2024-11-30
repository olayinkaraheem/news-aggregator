<?php

namespace App\Actions;

use App\Notifications\WelcomeUserNotification;

class SendWelcomeUserNotificationAction
{
  public function handle(array $data, \Closure $next = null)
  {
    $user = $data['user'];
    
    $user->notify(new WelcomeUserNotification($data));

    return $next ? $next($data) : true;
  }
}