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
        // for each section
        // category = source['category']
        // source = source['id']
        // NewsApiAggregatorBySourceJob::dispatch(source, category);
    }
    protected function fetchNewsApiAggregatorByCategory()
    {
        // for each category
        // NewsApiAggregatorByCategoryJob::dispatch(category);
    }
}
