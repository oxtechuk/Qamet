<?php

namespace App\Http\Controllers\Api\Store;

use App\Http\Controllers\Api\ApiBaseController;
use App\Services\Api\Store\HomeApiService;

final class HomeController extends ApiBaseController
{
    public function __construct(
        private readonly HomeApiService $homeService,
    ) {
        parent::__construct(app(\App\Http\Api\Response\Builder\ApiResponseBuilder::class));
    }

    public function __invoke()
    {
        return $this->respondSuccess($this->homeService->home(), 'Homepage data retrieved successfully');
    }
}
