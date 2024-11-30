<?php

namespace App\Jobs\NewsAggregators\NewsApi;

use Illuminate\Support\Arr;
use App\Jobs\StoreNewsAggregateJob;
use App\Helpers\Aggregator\NewsApiHelper;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewsApiAggregatorBySourceJob implements ShouldQueue
{
    use Queueable, ResponseTransformerTrait;

    /**
     * Create a new job instance.
     */
    public function __construct(protected string $source, protected string $category, protected int $page = 1)
    {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $response = (new NewsApiHelper)->getNews(filter_value: $this->source, filter_key: 'sources', page: $this->page);

        $totalPages = !empty($response) && Arr::has($response, 'totalResults') ? (int) $response['totalResults'] : 0;

        if (!$totalPages) {
            return;
        }

        $articles = $this->transformResponseFormat($response['articles']);

        StoreNewsAggregateJob::dispatch($articles);

        if ($this->page <= $totalPages) {
            NewsApiAggregatorBySourceJob::dispatch($this->source, $this->category, $this->page + 1)->delay(now()->addSeconds(5));
        }
    }
}
