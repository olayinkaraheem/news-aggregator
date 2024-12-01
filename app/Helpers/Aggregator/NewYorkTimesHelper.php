<?php

namespace App\Helpers\Aggregator;

use App\Helpers\MockResponse;
use App\Enums\NewsProviderEnum;
use Illuminate\Support\Facades\Log;
use App\Helpers\Http\NewsAggregatorRequest;

class NewYorkTimesHelper implements AggregatorInterface
{
    protected string $path;
    protected string $apiKey;
    protected string $baseUrl;

    public function __construct(protected string $provider = NewsProviderEnum::NEW_YORK_TIMES->value)
    {
        $provider_config = config('news-providers.' . $this->provider);
        $this->path = $provider_config['paths']['category'];
        $this->apiKey = $provider_config['api_key'];
        $this->baseUrl = $provider_config['base_url'];
    }
    public function getNews(string $filter_value, int $page = 1): array
    {
        $mockResponse = [];
        try {
            $response = (new NewsAggregatorRequest)->get(
                __("{$this->baseUrl}/{$this->path}?", ['category' => $filter_value]) . http_build_query([
                    'api-key' => $this->apiKey
                ]),
                mockResponse: $mockResponse
            );
        } catch (\Exception $e) {
            Log::error('Error fetching news from New York Times: '. $e->getMessage());
            return [];
        }

        Log::debug($response);

        return $response['data'];
    }

    public function getSources(): array
    {
        return [];
    }
}
