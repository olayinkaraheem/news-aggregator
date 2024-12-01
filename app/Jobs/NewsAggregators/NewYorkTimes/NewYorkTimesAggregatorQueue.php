<?php

namespace App\Jobs\NewsAggregators\NewYorkTimes;

use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewYorkTimesAggregatorQueue implements ShouldQueue
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
        $this->fetchNews();
    }

    protected function fetchNews()
    {
        $categories = config('data-sources.new-york-times-categories');

        $categories_to_fetch = collect($categories)->chunk(5); // max of 5 requests per time as specified by the provider

        $categories_to_fetch->each(function ($categories) {
            foreach ($categories as $category) {
                NewYorkTimesAggregatorJob::dispatch($category)->delay(now()->addSeconds(5));
            }
        });
    }
}
