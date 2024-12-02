<?php

use App\Models\User;
use App\Processors\UserPreferenceProcessor;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);
test('Verify extractFormat returns the right structure', function () {
    $user = User::factory()->withPreferences()->create();
    $user_preference = $user->userPreference;

    $data = (new UserPreferenceProcessor)->extract($user_preference);

    expect($data)->toBe([
        'sources' => $user_preference->sources,
        'authors' => $user_preference->authors,
        'categories' => $user_preference->categories,
    ]);
})->group('processors');
