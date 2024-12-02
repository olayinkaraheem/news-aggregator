<?php

use App\Actions\CreateNewsAggregateAction;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);
uses(WithFaker::class);

test('CreateNewsAggregateAction class works as expected', function () {
    $data = [
        'title' => $this->faker->sentence,
        'description' => $this->faker->paragraph,
        'image_url' => $this->faker->url,
        'url' => $this->faker->url,
        'content' => $this->faker->paragraphs(3, true),
        'category' => $this->faker->word,
        'author' => $this->faker->name,
        'source' => $this->faker->company,
        'published_date' => $this->faker->dateTimeBetween('-2 weeks', 'now'),
    ];

    $result = (new CreateNewsAggregateAction())->handle($data);

    $this->assertTrue($result);
    $this->assertDatabaseHas('news_aggregates', $data);
})->group('actions');
