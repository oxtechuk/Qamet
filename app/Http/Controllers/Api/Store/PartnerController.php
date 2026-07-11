<?php

namespace App\Http\Controllers\Api\Store;

use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Resources\Store\PartnerResource;
use App\Services\Api\Store\PartnerApiService;

final class PartnerController extends ApiBaseController
{
    public function __construct(
        private readonly PartnerApiService $partnerService,
    ) {
        parent::__construct(app(\App\Http\Api\Response\Builder\ApiResponseBuilder::class));
    }

    public function __invoke()
    {
        return $this->respondSuccess(
            PartnerResource::collection($this->partnerService->list())->resolve(),
            'Partners retrieved successfully'
        );
    }
}
