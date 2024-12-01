<?php

namespace App\Jobs\NewsAggregators\TheGuardian;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class TheGuardianAggregatorQueue implements ShouldQueue
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
        $sources = config('data-sources.the-guardian-categories');

        $sources_to_fetch = collect($sources)->random(5); // reduced to prevent rate limiting from provider. Update this to take more like 50

        $sources_to_fetch->each(function ($source) {
            TheGuardianAggregatorJob::dispatch($source['id'])->delay(now()->addSeconds(5));
        });
    }
}
