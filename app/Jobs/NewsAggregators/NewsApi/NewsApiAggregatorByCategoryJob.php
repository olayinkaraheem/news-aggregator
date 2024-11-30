<?php

namespace App\Jobs\NewsAggregators\NewsApi;

use Illuminate\Support\Arr;
use App\Helpers\Aggregator\NewsApiHelper;
use App\Jobs\StoreNewsAggregateJob;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewsApiAggregatorByCategoryJob implements ShouldQueue
{
    use Queueable, ResponseTransformerTrait;

    /**
     * Create a new job instance.
     */
    public function __construct(protected string $category, protected int $page = 1)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $response = (new NewsApiHelper)->getNews(filter_value: $this->category, page: $this->page);

        $totalPages = !empty($response) && Arr::has($response, 'totalResults') ? (int) $response['totalResults'] : 0;

        if (!$totalPages) {
            return;
        }

        $articles = $this->transformResponseFormat($response['articles']);

        StoreNewsAggregateJob::dispatch($articles);

        if ($this->page <= $totalPages) {
            NewsApiAggregatorByCategoryJob::dispatch($this->category, $this->page + 1)->delay(now()->addSeconds(5));
        }
    }
}
