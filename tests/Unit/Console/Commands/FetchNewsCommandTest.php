<?php

use App\Jobs\FetchNewsJob;
use App\Jobs\StoreNewsAggregateJob;
use Illuminate\Support\Facades\Queue;
use App\Jobs\NewsAggregators\NewsApi\NewsApiAggregatorQueue;
use App\Jobs\NewsAggregators\NewsApi\NewsApiAggregatorBySourceJob;
use App\Jobs\NewsAggregators\TheGuardian\TheGuardianAggregatorJob;
use App\Jobs\NewsAggregators\NewsApi\NewsApiAggregatorByCategoryJob;
use App\Jobs\NewsAggregators\NewYorkTimes\NewYorkTimesAggregatorJob;
use App\Jobs\NewsAggregators\TheGuardian\TheGuardianAggregatorQueue;
use App\Jobs\NewsAggregators\NewYorkTimes\NewYorkTimesAggregatorQueue;

test('Command app:fetch-news exited successfully', function () {
    Queue::fake();

    $this->artisan('app:fetch-news')->assertExitCode(0);

    Queue::assertPushed(FetchNewsJob::class);
})->group('console');

test('NewsApiAggregatorQueue dispatches source and category jobs', function () {
    Queue::fake();

    $queue = new NewsApiAggregatorQueue();
    $queue->handle();

    Queue::assertPushed(NewsApiAggregatorBySourceJob::class);
    Queue::assertPushed(NewsApiAggregatorByCategoryJob::class);
})->group('console');

test('TheGuardianAggregatorQueue dispatches TheGuardianAggregatorJob', function () {
    Queue::fake();

    $queue = new TheGuardianAggregatorQueue();
    $queue->handle();

    Queue::assertPushed(TheGuardianAggregatorJob::class);
})->group('console');

test('NewYorkTimesAggregatorQueue dispatches NewYorkTimesAggregatorJob', function () {
    Queue::fake();

    $queue = new NewYorkTimesAggregatorQueue();
    $queue->handle();

    $categories = config('data-sources.new-york-times-categories');

    Queue::assertPushed(NewYorkTimesAggregatorJob::class, function ($job) use ($categories) {
        return in_array($job->getCategory(), $categories);
    });

    $expectedJobCount = count($categories);
    $actualJobCount = collect(Queue::pushed(NewYorkTimesAggregatorJob::class))->count();
    expect($actualJobCount)->toBe($expectedJobCount);
})->group('console');

test('TheGuardianAggregatorJob dispatches StoreNewsAggregateJob', function () {
    Queue::fake();

    $queue = new TheGuardianAggregatorJob('business');
    $queue->handle();

    $categories = collect(config('data-sources.the-guardian-categories'));

    Queue::assertPushed(StoreNewsAggregateJob::class, function ($job) use ($categories) {
        return in_array('business', $categories->pluck('id')->toArray());
    });
})->group('console');

test('NewYorkTimesAggregatorJob dispatches StoreNewsAggregateJob', function () {
    Queue::fake();

    $queue = new NewYorkTimesAggregatorJob('world');
    $queue->handle();

    Queue::assertPushed(StoreNewsAggregateJob::class);
})->group('console');

test('NewsApiAggregatorBySourceJob dispatches StoreNewsAggregateJob', function () {
    Queue::fake();
    $sources = config('data-sources.news-api-sources');
    $categories = config('data-sources.news-api-categories');
    $queue = new NewsApiAggregatorBySourceJob($sources[0]['id'], $categories[0]);
    $queue->handle();

    Queue::assertPushed(StoreNewsAggregateJob::class);
})->group('console');

test('NewsApiAggregatorByCategoryJob dispatches StoreNewsAggregateJob', function () {
    Queue::fake();
    $categories = config('data-sources.news-api-categories');

    $queue = new NewsApiAggregatorByCategoryJob($categories[0]);
    $queue->handle();

    Queue::assertPushed(StoreNewsAggregateJob::class);
})->group('console');

