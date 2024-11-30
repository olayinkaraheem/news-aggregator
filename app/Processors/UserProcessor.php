<?php

namespace App\Processors;

use App\Models\User;

class UserProcessor
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {}

    public function extractFormat(User $user)
    {
        return [
            'name' => $user->name,
            'email' => $user->email,
            'email_verified' => !is_null($user->email_verified_at),
        ];
    }
}
