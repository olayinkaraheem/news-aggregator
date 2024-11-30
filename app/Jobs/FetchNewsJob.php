<?php

namespace App\Jobs;

use App\Enums\NewsProviderEnum;
use App\Services\NewsAggregatorJobFactory;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class FetchNewsJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(protected string $provider)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        NewsAggregatorJobFactory::make($this->provider)->fetchNews();
    }
}
