<?php

use App\Models\NewsAggregate;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Faker\Factory as Faker;

$faker = Faker::create();

uses(RefreshDatabase::class);

test('user can set news preference', function () {
    $user = User::factory()->create();
    $news_aggregates = NewsAggregate::factory(5)->create();

    Sanctum::actingAs($user);

    $preferences =  [
        'sources' => $news_aggregates->pluck('source')->take(2),
        'authors' => $news_aggregates->pluck('author')->take(2),
        'categories' => $news_aggregates->pluck('category')->take(2)
    ];

    $response = $this->postJson('api/v1/user/preferences', $preferences);

    $response->assertStatus(200)
        ->assertJson([
            "message" => "Preferences update successful",
        ])
        ->assertJsonStructure([
            "data" => [
                "sources",
                "authors",
                "categories",
            ]
        ]);
        $this->assertDatabaseHas('user_preferences', [
            'user_id' => $user->id,
        ]);
})->group('user-preference');

test('user can fetch their set news preference', function () {
    $user = User::factory()->create();

    $news_aggregates = NewsAggregate::factory(5)->create();

    Sanctum::actingAs($user);

    $preferences =  [
        'sources' => $news_aggregates->pluck('source')->take(2),
        'authors' => $news_aggregates->pluck('author')->take(2),
        'categories' => $news_aggregates->pluck('category')->take(2)
    ];

    $this->postJson('api/v1/user/preferences', $preferences);

    $response = $this->getJson('api/v1/user/preferences');

    $response->assertStatus(200)
        ->assertJson([
            "message" => "Preferences fetch successful",
        ])
        ->assertJsonStructure([
            "data" => [
                "sources",
                "authors",
                "categories",
            ]
        ]);
})->group('user-preference');

test('user can only select valid authors', function () use ($faker) {
    $user = User::factory()->create();

    $news_aggregates = NewsAggregate::factory(5)->create();

    Sanctum::actingAs($user);

    $preferences =  [
        'sources' => $news_aggregates->pluck('source')->take(2),
        'authors' => [$faker->name.'-1'],
        'categories' => $news_aggregates->pluck('category')->take(2)
    ];

    $response = $this->postJson('api/v1/user/preferences', $preferences);

    $response->assertStatus(422);

})->group('user-preference');

test('user can only select valid sources', function () use ($faker) {
    $user = User::factory()->create();

    $news_aggregates = NewsAggregate::factory(5)->create();

    Sanctum::actingAs($user);

    $preferences =  [
        'authors' => $news_aggregates->pluck('author')->take(2),
        'sources' => [$faker->name.'-1'],
        'categories' => $news_aggregates->pluck('category')->take(2)
    ];

    $response = $this->postJson('api/v1/user/preferences', $preferences);

    $response->assertStatus(422);
    
})->group('user-preference');

test('user can only select valid categories', function () use ($faker) {
    $user = User::factory()->create();

    $news_aggregates = NewsAggregate::factory(5)->create();

    Sanctum::actingAs($user);

    $preferences =  [
        'authors' => $news_aggregates->pluck('author')->take(2),
        'categories' => [$faker->name.'-1'],
        'sources' => $news_aggregates->pluck('source')->take(2)
    ];

    $response = $this->postJson('api/v1/user/preferences', $preferences);

    $response->assertStatus(422);
    
})->group('user-preference');