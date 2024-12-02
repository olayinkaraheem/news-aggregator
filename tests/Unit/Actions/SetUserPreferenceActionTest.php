<?php

use App\Models\User;
use App\Models\NewsAggregate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Actions\UserPreferenceManagement\UpdateOrCreateUserPreferenceAction;

uses(RefreshDatabase::class);

test('UpdatedOrCreateUserPreferenceAction works as expected', function () {

    $user = User::factory()->create();
    $news_aggregates = NewsAggregate::factory(5)->create();
    $preferences =  [
        'sources' => $news_aggregates->pluck('source')->take(2)->toArray(),
        'authors' => $news_aggregates->pluck('author')->take(2)->toArray(),
        'categories' => $news_aggregates->pluck('category')->take(2)->toArray()
    ];

    $result = (new UpdateOrCreateUserPreferenceAction)->handle(['user' => $user, ...$preferences]);

    $user_preference = $user->userPreference;

    $this->assertTrue($result);
    $this->expect($user_preference->sources)->toBe($preferences['sources']);
    $this->expect($user_preference->authors)->toBe($preferences['authors']);
    $this->expect($user_preference->categories)->toBe($preferences['categories']);
})->group('actions');
