<?php

namespace App\Http\Controllers\Api\Store;

use App\Http\Controllers\Api\ApiBaseController;
use App\Services\Api\Store\AboutApiService;

final class AboutController extends ApiBaseController
{
    public function __construct(
        private readonly AboutApiService $aboutService,
    ) {
        parent::__construct(app(\App\Http\Api\Response\Builder\ApiResponseBuilder::class));
    }

    public function __invoke()
    {
        return $this->respondSuccess($this->aboutService->about(), 'About page data retrieved successfully');
    }
}
