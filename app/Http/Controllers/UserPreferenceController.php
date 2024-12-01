<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Helpers\Http\NewsAggregatorResponse;
use App\Http\Requests\UserPreferenceRequest;
use App\Services\UserPreferenceManagementService;

class UserPreferenceController extends Controller
{
    public function __construct(protected UserPreferenceManagementService $userPreferenceManagementService)
    {}
    
    public function setPreferences(UserPreferenceRequest $request): JsonResponse
    {
        // dd(\App\Models\NewsAggregate::where('source', 'like', "%News%")->pluck('source')->unique()->paginate());
        $data = $this->userPreferenceManagementService->setPreferences($request->user(), $request->validated());

        return (new NewsAggregatorResponse(
            data: $data,
            message: __('general.successful', ['action' => 'Preferences update'])
        ))->asSuccessful();
    }
    public function getPreferences(Request $request): JsonResponse
    {
        $data = $this->userPreferenceManagementService->getPreferences($request->user());

        return (new NewsAggregatorResponse(
            data: $data,
            message: __('general.successful', ['action' => 'Preferences fetch'])
        ))->asSuccessful();
    }
}