<?php

namespace App\Http\Controllers\Api\Store;

use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Resources\Store\PartnerResource;
use App\Http\Resources\Store\TestimonialResource;
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
        $data = $this->aboutService->about();

        $data['testimonials'] = TestimonialResource::collection($data['testimonials'])->resolve();
        $data['partners'] = PartnerResource::collection($data['partners'])->resolve();

        return $this->respondSuccess($data, 'About page data retrieved successfully');
    }
}
