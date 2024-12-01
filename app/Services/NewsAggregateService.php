<?php

namespace App\Services;

use App\Models\User;
use App\Processors\NewsAggregateProcessor;

class NewsAggregateService
{
    public function listAuthors(?string $search = null): array
    {
        return (new NewsAggregateProcessor())
            ->applySearchFilter('author', $search)
            ->unique('author')
            ->paginate()
            ->list();
    }

    public function listSources(?string $search = null): array
    {
        return (new NewsAggregateProcessor())
            ->applySearchFilter('source', $search)
            ->unique('source')
            ->paginate()
            ->list();
    }

    public function listCategories(?string $search = null): array
    {
        return (new NewsAggregateProcessor())
            ->applySearchFilter('category', $search)
            ->unique('category')
            ->paginate()
            ->list();
    }

    public function listUserPreferedNews(User $user): array
    {
        return (new NewsAggregateProcessor())
            ->applyUserPreferenceFilters($user->userPreference)
            ->latest()
            ->paginate()
            ->extract();
    }
    public function listNews(array $request_data): array
    {
        return (new NewsAggregateProcessor())
            ->applyListFilters($request_data)
            ->latest()
            ->paginate()
            ->extract();
    }

    public function viewSingleNewsItem(array $request_data): array
    {
        return (new NewsAggregateProcessor())
            ->whereId($request_data['id'])
            ->extractFirst();
    }
}
