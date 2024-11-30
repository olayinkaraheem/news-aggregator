<?php

namespace App\Jobs;

use App\Actions\CreateNewsAggregateAction;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class StoreNewsAggregateJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(protected array $articles)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        collect($this->articles)
            ->filter(fn($article) => $article['title'] != "[Removed]")
            ->each(fn($article) => (new CreateNewsAggregateAction)->handle($article));
    }
}