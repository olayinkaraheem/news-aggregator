<?php

use App\Models\User;
use App\Models\NewsAggregate;
use App\Processors\NewsAggregateProcessor;
use Illuminate\Foundation\Testing\RefreshDatabase;


uses(RefreshDatabase::class);

test('Verify extractFormat returns the right structure', function () {
    $news_aggregate = NewsAggregate::factory()->create();
    $data = (new NewsAggregateProcessor)->extractFormat($news_aggregate);

    expect($data)->toBe([
        'id' => $news_aggregate->id,
        'title' => $news_aggregate->title,
        'source' => $news_aggregate->source,
        'category' => $news_aggregate->category,
        'author' => $news_aggregate->author,
        'description' => $news_aggregate->description,
        'image_url' => $news_aggregate->image_url,
    ]);
})->group('processors');

test('Verify paginate returns paginated data', function () {
    NewsAggregate::factory(20)->create();

    $data = (new NewsAggregateProcessor)->paginate()->extract();

    expect($data)->toHaveKey('data');
    expect($data)->toHaveKey('meta');
})->group('processors');

test('User Preference matches listed news', function(){
    $user = User::factory()->withPreferences()->create();
    NewsAggregate::factory(20)->create([
        'source' => $user->userPreference->sources[0],
        'category' => $user->userPreference->categories[0],
        'author' => $user->userPreference->authors[0],
    ]);

    $data = (new NewsAggregateProcessor)->applyUserPreferenceFilters($user->userPreference)->paginate()->extract();

    expect($data)->toHaveKey('data');
    expect($data)->toHaveKey('meta');
})->group('processors');
