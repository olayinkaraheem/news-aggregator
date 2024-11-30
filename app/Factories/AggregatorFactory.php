<?php
namespace App\Services;

use Exception;
use App\Enums\NewsProviderEnum;
use App\Helpers\Aggregator\NewsApiHelper;
use App\Helpers\Aggregator\AggregatorInterface;

class AggregatorFactory {
    protected function __construct(protected string $provider)
    {}

    public static function make($provider): AggregatorInterface
    {
        return (new self($provider))->getInstance();
    }

    /**
     * Get an instance of the AggregatorInterface
     * 
     * @return AggregatorInterface
     */
    protected function getInstance(): AggregatorInterface
    {
        return match($this->provider) {
            NewsProviderEnum::NEWSAPI->value => new NewsApiHelper,
            default => throw new Exception('Provider not supported yet.')
        };
    }
}