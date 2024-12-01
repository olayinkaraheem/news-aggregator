<?php

namespace App\Jobs\NewsAggregators\NewsApi;

use Illuminate\Support\Arr;
use App\Enums\NewsProviderEnum;
use App\Jobs\StoreNewsAggregateJob;
use App\Helpers\Aggregator\NewsApiHelper;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewsApiAggregatorBySourceJob implements ShouldQueue
{
    use Queueable, ResponseTransformerTrait;

    protected int $pageSize;
    protected string $provider;

    /**
     * Create a new job instance.
     */
    public function __construct(protected string $source, protected string $category, protected int $page = 1)
    {
        $this->pageSize = (int) config('news-providers.'.NewsProviderEnum::NEWSAPI->value.'.page_size');
        $this->provider = NewsProviderEnum::NEWSAPI->value;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $response = (new NewsApiHelper)->getNews(filter_value: $this->source, filter_key: 'sources', page: $this->page);

        $totalResults = !empty($response) && Arr::has($response, 'totalResults') ? (int) $response['totalResults'] : 0;

        if (!$totalResults) {
            return;
        }

        $totalPages = (int) ceil($totalResults / $this->pageSize);

        $articles = $this->transformResponseFormat($response['articles']);

        $page = $this->page + 1;

        StoreNewsAggregateJob::dispatch($articles);

        if ($page <= $totalPages) {
            NewsApiAggregatorBySourceJob::dispatch($this->source, $this->category, $page)->delay(now()->addSeconds(5));
        }
    }
}
