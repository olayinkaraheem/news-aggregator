<?php

namespace App\Jobs\NewsAggregators\NewYorkTimes;

use Illuminate\Support\Arr;
use App\Enums\NewsProviderEnum;
use App\Helpers\Aggregator\NewYorkTimesHelper;
use App\Jobs\StoreNewsAggregateJob;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewYorkTimesAggregatorJob implements ShouldQueue
{
    use Queueable;

    protected string $provider;

    /**
     * Create a new job instance.
     */
    public function __construct(protected string $category, protected int $page = 1)
    {
        $this->provider = NewsProviderEnum::NEW_YORK_TIMES->value;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $response = (new NewYorkTimesHelper())->getNews(filter_value: $this->category);

        $totalResults = !empty($response) && Arr::has($response, 'num_results') ? (int) $response['num_results'] : 0;

        if (!$totalResults) {
            return;
        }

        $results = $this->transformResponseFormat($response['results']);

        StoreNewsAggregateJob::dispatch($results);
    }

    protected function transformResponseFormat(array $results): array
    {
        return collect($results)->map(function ($result) {
            return [
                'title' => $result['title'],
                'content' => $result['title'],
                'url' => $result['url'],
                'source' => $this->getProviderReadableName(),
                'published_date' => $result['published_date'],
                'image_url' => Arr::get($result, 'multimedia.0.url') ?? '',
                'author' => strlen($result['byline']) ? ltrim($result['byline'], 'By ') : $this->getProviderReadableName(),
                'category' => strlen($result['subsection']) ? $result['subsection'] : $this->category,
                'description' => $result['abstract'],
            ];
        })->toArray();
    }

    protected function getProviderReadableName()
    {
        return ucwords(str_replace('_', ' ', $this->provider));
    }

    public function getCategory()
    {
        return $this->category;
    }
}
