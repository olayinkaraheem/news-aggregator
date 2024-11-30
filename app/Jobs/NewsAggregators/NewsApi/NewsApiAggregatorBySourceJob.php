<?php

namespace App\Jobs\NewsAggregators\NewsApi;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class NewsApiAggregatorBySourceJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(protected string $source, protected string $category, protected int $page = 1)
    {
        // $this->category to be used when saving the content
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // call NewsApiHelper getNews(filter_value: $this->source, filter_key: 'sources', page: $this->page)
    }
}
