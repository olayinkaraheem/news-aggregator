<?php
namespace App\Actions\UserPreferenceManagement;

use App\Models\UserPreference;

class UpdateOrCreateUserPreferenceAction
{
    public function handle(array $data, \Closure $next = null)
    {
        $user_preference = UserPreference::updateOrCreate([
            'user_id' => $data['user']->id],
            $data
        );

        $data['user_preference'] = $user_preference;

        return $next ? $next($data) : true;
    }
}