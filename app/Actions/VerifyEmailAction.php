<?php

namespace App\Actions;

class VerifyEmailAction
{
  public function handle(array $data, \Closure $next = null)
  {
    $user = $data['user'];
    
    $user->update(['email_verified_at' => now()]);

    return $next ? $next($data) : true;
  }
}