<?php

namespace App\Http\Controllers\Api\Store;

use App\Http\Api\Contracts\ApiResponse;
use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Resources\Store\SettingResource;
use App\Services\Api\Store\SettingApiService;
use Illuminate\Http\Request;

final class SettingsController extends ApiBaseController
{
    public function __construct(
        private readonly SettingApiService $settingService,
    ) {
        parent::__construct(app(\App\Http\Api\Response\Builder\ApiResponseBuilder::class));
    }

    public function footer(): ApiResponse
    {
        return $this->respondSuccess(
            $this->settingService->footer(),
            'Footer data retrieved successfully'
        );
    }

    public function getFinanceSolution(): ApiResponse
    {
        return $this->respondSuccess(
            $this->settingService->financeSolution(),
            'Finance solution data retrieved successfully'
        );
    }

    public function index(Request $request)
    {
        $keys = $request->query('keys');

        if (is_string($keys)) {
            $keys = explode(',', $keys);
        }

        $keys = is_array($keys) ? $keys : null;

        $settings = $this->settingService->list($keys);

        $items = collect($settings)->map(fn ($value, $key) => [
            'key' => $key,
            'value' => $value,
        ])->values();

        return $this->respondSuccess(
            SettingResource::collection($items)->resolve(),
            'Settings retrieved successfully'
        );
    }
}
