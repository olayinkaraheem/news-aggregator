<?php

use App\Enums\NewsProviderEnum;
use Illuminate\Support\Facades\Queue;
use App\Factories\NewsAggregatorJobFactory;
use App\Jobs\NewsAggregators\NewsApi\NewsApiAggregatorQueue;
use App\Jobs\NewsAggregators\NewYorkTimes\NewYorkTimesAggregatorQueue;
use App\Jobs\NewsAggregators\TheGuardian\TheGuardianAggregatorQueue;

test('The right provider queue was disptched', function ($provider) {
    Queue::fake();

    NewsAggregatorJobFactory::make($provider);

    match ($provider) {
        NewsProviderEnum::NEWSAPI->value => Queue::assertPushed(NewsApiAggregatorQueue::class),
        NewsProviderEnum::THE_GUARDIAN->value => Queue::assertPushed(TheGuardianAggregatorQueue::class),
        NewsProviderEnum::NEW_YORK_TIMES->value => Queue::assertPushed(NewYorkTimesAggregatorQueue::class),
    };
})
->with(NewsProviderEnum::valueArray())
->group('aggregator-job-factory');

test('The an exception is thrown for unsupported provider', function () {
    Queue::fake();

    $this->expect(fn() => NewsAggregatorJobFactory::make('unsupported_provider'))
        ->toThrow(\Exception::class);

    Queue::assertNothingPushed();
})->group('aggregator-job-factory');
