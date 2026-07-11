<?php

namespace App\Http\Controllers\Api\Store;

use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Resources\Store\TestimonialResource;
use App\Services\Api\Store\TestimonialApiService;

final class TestimonialController extends ApiBaseController
{
    public function __construct(
        private readonly TestimonialApiService $testimonialService,
    ) {
        parent::__construct(app(\App\Http\Api\Response\Builder\ApiResponseBuilder::class));
    }

    public function __invoke()
    {
        return $this->respondSuccess(
            TestimonialResource::collection($this->testimonialService->list())->resolve(),
            'Testimonials retrieved successfully'
        );
    }
}
