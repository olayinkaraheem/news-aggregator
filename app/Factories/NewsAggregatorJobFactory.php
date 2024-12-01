<?php
namespace App\Factories;

use Exception;
use App\Enums\NewsProviderEnum;
use App\Helpers\Aggregator\AggregatorInterface;
use App\Jobs\NewsAggregators\NewsApi\NewsApiAggregatorQueue;
use App\Jobs\NewsAggregators\TheGuardian\TheGuardianAggregatorQueue;

class NewsAggregatorJobFactory {
    protected function __construct(protected string $provider)
    {}

    public static function make($provider): void
    {
        (new self($provider))->getInstance();
    }

    /**
     * Get an instance of the AggregatorInterface
     * 
     * @return AggregatorInterface
     */
    protected function getInstance(): void
    {
        match($this->provider) {
            NewsProviderEnum::NEWSAPI->value => NewsApiAggregatorQueue::dispatch(),
            NewsProviderEnum::THE_GUARDIAN->value => TheGuardianAggregatorQueue::dispatch(),
            default => throw new Exception('Provider not supported yet.')
        };
    }
}