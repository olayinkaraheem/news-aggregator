<?php

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use App\Models\NewsAggregate;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    Sanctum::actingAs(User::factory()->create());
});

$dataset = [
    ['resource' => 'categories', 'key' => 'category'],
    ['resource' => 'authors', 'key' => 'author'],
    ['resource' => 'sources', 'key' => 'source']
];

foreach ($dataset as $value) {
    $resource = $value['resource'];
    $field = $value['key'];
    test("{$resource} are listed successfully", function () use ($resource) {

        $response = $this->getJson('/api/v1/news/' . $resource);

        $response->assertStatus(200);
    })->group('news-management');

    test("{$resource} listed are unique", function () use ($resource, $field) {

        $news_aggregates = NewsAggregate::factory(5)->create([
            $field => $field . ' 1'
        ]);

        $unique_resource = $news_aggregates->pluck($field)->unique()->count();

        $response = $this->getJson('/api/v1/news/' . $resource);

        $response->assertStatus(200)
            ->assertJsonCount($unique_resource, 'data');
    })->group('news-management');
}

test('all news are fetched successfully and are paginated', function () {
    NewsAggregate::factory(20)->create();

    $response = $this->getJson('/api/v1/news');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                '*' => [
                    'id',
                    'title',
                    'source',
                    'category',
                    'author',
                    'description',
                    'image_url',
                ]
            ],
            'meta' => [
                'current_page',
                'from',
                'last_page',
                'per_page',
                'to',
                'total',
                'links' => [
                    'first',
                    'last',
                    'prev',
                    'next',
                ],
            ]
        ]);
    $this->assertEquals(20, $response->json('meta.total'));
    $this->assertEquals($response->json('meta.per_page'), count($response->json('data')));
})->group('news-management');

test('user can view a single news item', function () {
    $news_aggregate = NewsAggregate::factory()->create();

    $response = $this->getJson('/api/v1/news/view?id=' . $news_aggregate->id);

    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'data' => [
                'id',
                'title',
                'source',
                'category',
                'author',
                'description',
                'image_url',
            ],
            'message'
        ]);
})->group('news-management');
