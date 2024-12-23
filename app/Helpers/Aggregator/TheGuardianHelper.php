<?php

namespace App\Helpers\Aggregator;

use App\Helpers\MockResponse;
use App\Enums\NewsProviderEnum;
use Illuminate\Support\Facades\Log;
use App\Helpers\Http\NewsAggregatorRequest;

class TheGuardianHelper implements AggregatorInterface
{
    protected string $path;
    protected string $apiKey;
    protected string $baseUrl;
    protected int $pageSize;

    /**
     * Constructor for TheGuardianHelper.
     *
     * @param string $provider The news provider to use (default: NewsProviderEnum::THE_GUARDIAN->value)
     */
    public function __construct(protected string $provider = NewsProviderEnum::THE_GUARDIAN->value)
    {
        $provider_config = config('news-providers.' . $this->provider);
        $this->path = $provider_config['paths']['search'];
        $this->apiKey = $provider_config['api_key'];
        $this->baseUrl = $provider_config['base_url'];
        $this->pageSize = (int) $provider_config['page_size'];
    }

    /**
     * Get news from The Guardian.
     *
     * @param string $filter_value The value to filter the news by (e.g., 'sports', 'business')
     */
    public function getNews(string $filter_value, int $page = 1, string $filter_key = 'section'): array
    {
        $mockResponse = app()->environment('testing') ? MockResponse::getTheGuardianMockResponse() : [];
        try {
            $response = (new NewsAggregatorRequest)->get(
                "{$this->baseUrl}/{$this->path}?" . http_build_query([
                    'api-key' => $this->apiKey,
                    $filter_key => $filter_value,
                    'page' => $page,
                    'pageSize' => $this->pageSize,
                    'from-date' => now()->format('Y-m-d')
                ]),
                mockResponse: $mockResponse
            );
        } catch (\Exception $e) {
            Log::error('Error fetching news from TheGuardian news: ' . $e->getMessage());
            return [];
        }

        return $response['data']['response'];
    }
}
