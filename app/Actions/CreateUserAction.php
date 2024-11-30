<?php

namespace App\Actions;

use App\Models\User;

class CreateUserAction
{
    public function handle(array $data, \Closure $next = null)
    {
        $user = User::firstOrCreate([
                'email' => $data['email'],
            ],
            [
                'name' => ucwords($data['name']),
                'email' => $data['email'],
                'password' => $data['password']
            ]);

        $data['user'] = $user;

        return $next ? $next($data) : true;
    }
}
