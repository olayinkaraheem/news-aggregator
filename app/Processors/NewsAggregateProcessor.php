<?php

namespace App\Processors;

use Illuminate\Support\Arr;
use App\Models\NewsAggregate;
use App\Models\UserPreference;
use App\Helpers\NewsAggregatorPaginator;
use Illuminate\Database\Eloquent\Builder;

class NewsAggregateProcessor
{
    private Builder $newsAggregateQuery;
    private NewsAggregatorPaginator $paginatedNewsAggregateData;

    public function __construct()
    {
        $this->initialize();
    }

    private function initialize(): self
    {
        $this->newsAggregateQuery = NewsAggregate::query();

        return $this;
    }

    public function applyUserPreferenceFilters(?UserPreference $preference = null)
    {
        if ($preference) {
            if (!empty($preference->sources)) {
                $this->newsAggregateQuery->whereIn('source', $preference->sources);
            }
            if (!empty($preference->authors)) {
                $this->newsAggregateQuery->orWhereIn('author', $preference->authors);
            }
            if (!empty($preference->categories)) {
                $this->newsAggregateQuery->orWhereIn('category', $preference->categories);
            }
        }

        return $this;
    }


    public function applyListFilters(array $filters)
    {
        $this->newsAggregateQuery
            ->when(Arr::get($filters, 'keyword'), fn($q) => $q->whereAny([
                'title',
                'description',
                'content'
            ], 'like', "%" . Arr::get($filters, 'keyword') . "%"))
            ->when(Arr::get($filters, 'category'), fn($q) => $q->whereCategory(Arr::get($filters, 'category')))
            ->when(Arr::get($filters, 'date'), fn($q) => $q->wherePublishedDate(Arr::get($filters, 'date')))
            ->when(Arr::get($filters, 'source'), fn($q) => $q->whereSource(Arr::get($filters, 'source')));

        return $this;
    }

    public function applySearchFilter(?string $field = null, ?string $value = null)
    {
        $this->newsAggregateQuery->when($field && $value, fn($q) => $q->where($field, 'like', '%' . $value . '%'));

        return $this;
    }

    public function whereId(int $id)
    {
        $this->newsAggregateQuery->whereId($id);

        return $this;
    }

    public function latest(string $field = 'created_at')
    {
        $this->newsAggregateQuery->latest($field);

        return $this;
    }

    public function unique($field)
    {
        $this->newsAggregateQuery
            ->select($field)
            ->distinct()
            ->groupBy($field)
            ->latest($field);

        return $this;
    }

    public function paginate()
    {
        $results = $this->newsAggregateQuery->paginate(request()->per_page);
        $this->paginatedNewsAggregateData = new NewsAggregatorPaginator($results);

        return $this;
    }

    public function list()
    {
        return [
            'data' => collect($this->paginatedNewsAggregateData->getData())
                ->transform(fn($item) => Arr::first($item->toArray()))->toArray(),
            'meta' => $this->paginatedNewsAggregateData->getMeta()
        ];
    }


    public function extract()
    {
        $data = collect($this->paginatedNewsAggregateData->getData())
            ->transform(fn($newsAggregrate) => $this->extractFormat($newsAggregrate))
            ->toArray();

        return ['data' => $data, 'meta' => $this->paginatedNewsAggregateData->getMeta()];
    }

    public function extractFirst()
    {
        $newsAggregrate = $this->newsAggregateQuery->first();

        return $this->extractFormat($newsAggregrate);
    }

    public function extractFormat(NewsAggregate $newsAggregrate)
    {
        return [
            'id' => $newsAggregrate->id,
            'title' => $newsAggregrate->title,
            'source' => $newsAggregrate->source,
            'category' => $newsAggregrate->category,
            'author' => $newsAggregrate->author,
            'description' => $newsAggregrate->description,
            'image_url' => $newsAggregrate->image_url,
        ];
    }
}
