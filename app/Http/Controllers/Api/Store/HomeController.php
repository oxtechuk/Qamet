<?php

namespace App\Http\Controllers\Api\Store;

use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Resources\Store\BrandResource;
use App\Http\Resources\Store\BrandTypeResource;
use App\Http\Resources\Store\CarCategoryResource;
use App\Http\Resources\Store\CarMiniResource;
use App\Http\Resources\Store\CarTypeResource;
use App\Http\Resources\Store\HomeOfferResource;
use App\Http\Resources\Store\PartnerResource;
use App\Http\Resources\Store\TestimonialResource;
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
        $data = $this->homeService->home();

        $data['featured_cars'] = CarMiniResource::collection($data['featured_cars'])->resolve();
        $data['active_offers'] = HomeOfferResource::collection($data['active_offers'])->resolve();
        $data['bento_cars'] = CarMiniResource::collection($data['bento_cars'])->resolve();
        $data['highlighted_cars'] = CarMiniResource::collection($data['highlighted_cars'])->resolve();
        $data['brands'] = BrandResource::collection($data['brands'])->resolve();
        $data['filter_brands'] = BrandResource::collection($data['filter_brands'])->resolve();
        $data['filter_categories'] = CarCategoryResource::collection($data['filter_categories'])->resolve();
        $data['filter_types'] = CarTypeResource::collection($data['filter_types'])->resolve();
        $data['filter_brand_types'] = BrandTypeResource::collection($data['filter_brand_types'])->resolve();
        $data['latest_posts'] = $data['latest_posts']->toArray();
        $data['testimonials'] = TestimonialResource::collection($data['testimonials'])->resolve();
        $data['partners'] = PartnerResource::collection($data['partners'])->resolve();

        return $this->respondSuccess($data, 'Homepage data retrieved successfully');
    }
}
