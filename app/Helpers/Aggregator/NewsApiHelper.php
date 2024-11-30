<?php

namespace App\Helpers\Aggregator;

use App\Helpers\MockResponse;
use App\Enums\NewsProviderEnum;
use Illuminate\Support\Facades\Log;
use App\Helpers\Http\NewsAggregatorRequest;

class NewsApiHelper implements AggregatorInterface
{
    protected string $path;
    protected string $apiKey;
    protected string $baseUrl;
    protected int $pageSize;

    public function __construct(protected string $provider = NewsProviderEnum::NEWSAPI->value)
    {
        $provider_config = config('news-providers.' . $this->provider);
        $this->path = $provider_config['paths']['top_headlines'];
        $this->apiKey = $provider_config['api_key'];
        $this->baseUrl = $provider_config['base_url'];
        $this->pageSize = (int) $provider_config['page_size'];
    }
    public function getNews(string $filter_value, int $page = 1, string $filter_key = 'category'): array
    {
        $mockResponse = [];
        try {
            $response = (new NewsAggregatorRequest)->get(
                "{$this->baseUrl}/{$this->path}?" . http_build_query([
                    'apiKey' => $this->apiKey,
                    $filter_key => $filter_value,
                    'page' => $page,
                    'pageSize' => $this->pageSize,
                ]),
                mockResponse: $mockResponse
            );
        } catch (\Exception $e) {
            Log::error('Error fetching news from NewsApi: '. $e->getMessage());
            return [];
        }

        return $response['data'];
    }

    public function getSources(): array
    {
        return [];
    }
}
