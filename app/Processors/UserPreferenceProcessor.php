<?php

namespace App\Processors;

use App\Models\UserPreference;

class UserPreferenceProcessor
{
    public function __construct()
    {}

    public function extract(UserPreference $user_preference): array
    {
        return [
            'sources' => $user_preference->sources,
            'authors' => $user_preference->authors,
            'categories' => $user_preference->categories,
        ];
    }
}
