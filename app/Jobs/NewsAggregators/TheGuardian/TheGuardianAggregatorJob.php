<?php

namespace App\Jobs\NewsAggregators\TheGuardian;

use Illuminate\Support\Arr;
use App\Enums\NewsProviderEnum;
use App\Jobs\StoreNewsAggregateJob;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Helpers\Aggregator\TheGuardianHelper;

class TheGuardianAggregatorJob implements ShouldQueue
{
    use Queueable;

    protected int $pageSize;
    protected string $provider;

    /**
     * Create a new job instance.
     */
    public function __construct(protected string $category, protected int $page = 1)
    {
        $this->pageSize = (int) config('news-providers.'.NewsProviderEnum::THE_GUARDIAN->value.'.page_size');
        $this->provider = NewsProviderEnum::THE_GUARDIAN->value;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $response = (new TheGuardianHelper)->getNews(filter_value: $this->category, page: $this->page);

        dump('response: ', $response);

        $totalResults = !empty($response) && Arr::has($response, 'total') ? (int) $response['total'] : 0;

        dump('totalResults: ', $totalResults);

        if (!$totalResults) {
            return;
        }

        $totalPages = (int) ceil($totalResults / $response['pageSize']);

        $results = $this->transformResponseFormat($response['results']);

        dump('results: ', $results);

        $page = $this->page + 1;

        StoreNewsAggregateJob::dispatch($results);

        if ($page <= $totalPages) {
            TheGuardianAggregatorJob::dispatch($this->category, $page)->delay(now()->addSeconds(5));
        }
    }

    protected function transformResponseFormat(array $results): array
    {
        return collect($results)->map(function ($result) {
            return [
                'title' => $result['webTitle'],
                'content' => $result['webTitle'],
                'url' => $result['webUrl'],
                'source' => $this->provider,
                'published_date' => $result['webPublicationDate'],
                'image_url' => '',
                'author' => 'The Guardian',
                'category' => $result['sectionName'],
                'description' => null,
            ];
        })->toArray();
    } 
}
