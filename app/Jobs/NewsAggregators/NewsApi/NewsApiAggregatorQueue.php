<?php

namespace App\Jobs\NewsAggregators\NewsApi;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class NewsApiAggregatorQueue implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->fetchNewsApiAggregatorBySource();
        $this->fetchNewsApiAggregatorByCategory();
    }

    protected function fetchNewsApiAggregatorBySource()
    {
        $sources = config('data-sources.news-api-sources');

        $sources_to_fetch = collect($sources)->random(5); // reduced to prevent rate limiting from provider. Update this to take more like 50

        $sources_to_fetch->each(function ($source) {
            NewsApiAggregatorBySourceJob::dispatch($source['category'], $source['id'])->delay(now()->addSeconds(5));
        });
    }

    protected function fetchNewsApiAggregatorByCategory()
    {
        $categories = config('data-sources.news-api-categories');
        foreach ($categories as $category) {
            NewsApiAggregatorByCategoryJob::dispatch($category)->delay(now()->addSeconds(5));
        }
    }
}
