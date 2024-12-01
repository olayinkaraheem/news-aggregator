<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\ListNewsRequest;
use App\Services\NewsAggregateService;
use App\Helpers\Http\NewsAggregatorResponse;
use App\Http\Requests\ViewSingleNewsRequest;

class NewsController extends Controller
{
    public function __construct(protected NewsAggregateService $newsAggregateService) {}

    public function listAuthors(Request $request): JsonResponse
    {
        ['data' => $data, 'meta' => $meta] = $this->newsAggregateService->listAuthors($request->search);

        return (new NewsAggregatorResponse(
            data: $data,
            meta: $meta,
            message: __('general.successful', ['action' => 'Authors listing'])
        ))->asSuccessful();
    }

    public function listSources(Request $request): JsonResponse
    {
        ['data' => $data, 'meta' => $meta] = $this->newsAggregateService->listSources($request->search);

        return (new NewsAggregatorResponse(
            data: $data,
            meta: $meta,
            message: __('general.successful', ['action' => 'Sources listing'])
        ))->asSuccessful();
    }

    public function listCategories(Request $request): JsonResponse
    {
        ['data' => $data, 'meta' => $meta] = $this->newsAggregateService->listCategories($request->search);

        return (new NewsAggregatorResponse(
            data: $data,
            meta: $meta,
            message: __('general.successful', ['action' => 'Categories listing'])
        ))->asSuccessful();
    }

    public function viewSingleNewsItem(ViewSingleNewsRequest $request): JsonResponse
    {
        $data = $this->newsAggregateService->viewSingleNewsItem($request->validated());

        return (new NewsAggregatorResponse(
            data: $data,
            message: __('general.successful', ['action' => 'Action'])
        ))->asSuccessful();
    }
    public function listUserPreferedNews(Request $request): JsonResponse
    {
        ['data' => $data, 'meta' => $meta] = $this->newsAggregateService->listUserPreferedNews($request->user());

        return (new NewsAggregatorResponse(
            data: $data,
            meta: $meta,
            message: __('general.successful', ['action' => 'Action'])
        ))->asSuccessful();
    }

    public function listNews(ListNewsRequest $request): JsonResponse
    {
        ['data' => $data, 'meta' => $meta] = $this->newsAggregateService->listNews($request->validated());

        return (new NewsAggregatorResponse(
            data: $data,
            meta: $meta,
            message: __('general.successful', ['action' => 'Action'])
        ))->asSuccessful();
    }
}
