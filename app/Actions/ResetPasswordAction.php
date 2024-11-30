<?php

namespace App\Actions;

use Illuminate\Support\Facades\Hash;

class ResetPasswordAction
{
    public function handle(array $data, \Closure $next = null)
    {
        $data['user']->forceFill([
            'password' => Hash::make($data['password']),
        ])->save();

        return $next ? $next($data) : true;
    }
}
