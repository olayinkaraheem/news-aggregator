<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Pipeline\Pipeline;
use App\Actions\UserPreferenceManagement\UpdateOrCreateUserPreferenceAction;
use App\Processors\UserPreferenceProcessor;

class UserPreferenceManagementService
{
    public function setPreferences(User $user, array $request_data): array
    {
        ['user_preference' => $user_preference] = app(Pipeline::class)->send([
            'user' => $user,
            'sources' => Arr::get($request_data, 'sources', []),
            'authors' => Arr::get($request_data, 'authors', []),
            'categories' => Arr::get($request_data, 'categories', []),
        ])->through([
            UpdateOrCreateUserPreferenceAction::class
        ])->thenReturn();

        return (new UserPreferenceProcessor)->extract($user_preference);
    }

    public function getPreferences(User $user): array
    {
        if(!$user->userPreference)
        {
            return [];
        }
        return (new UserPreferenceProcessor)->extract($user->userPreference);
    }
}
