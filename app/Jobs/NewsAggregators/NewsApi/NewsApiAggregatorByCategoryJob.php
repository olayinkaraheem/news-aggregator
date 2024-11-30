<?php

namespace App\Jobs\NewsAggregators\NewsApi;

use App\Helpers\Aggregator\NewsApiHelper;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewsApiAggregatorByCategoryJob implements ShouldQueue
{
    use Queueable;

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

        $totalPages = !empty($response) ? (int) $response['totalResults'] : 0;

        if (!$totalPages) {
            return;
        }

        
        // this calls itself recursively going through the pages until the last page
        // on each iteration, performs a transform (maybe using a method here) and then
        // call a CreateNewsAggregateAction class



        // call NewsApiHelper getNews(filter_value: $this->category, page: $this->page)
    }
}
