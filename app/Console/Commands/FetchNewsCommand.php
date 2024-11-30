<?php

namespace App\Console\Commands;

use App\Jobs\FetchNewsJob;
use App\Enums\NewsProviderEnum;
use Illuminate\Console\Command;

class FetchNewsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-news';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch news from integrated providers';

    /**
     * Execute the console command.
     */
    public function __invoke()
    {
        collect(NewsProviderEnum::valueArray())->each(fn($provider) => FetchNewsJob::dispatch($provider));
    }
}
