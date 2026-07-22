<?php

namespace App\Http\Controllers\Api\Store;

use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Resources\Store\OfferResource;
use App\Services\Api\Store\OfferApiService;
use Illuminate\Http\Request;

final class OfferController extends ApiBaseController
{
    public function __construct(
        private readonly OfferApiService $offerService,
        private readonly \App\Services\Cache\OfferCacheService $offerCache,
    ) {
        parent::__construct(app(\App\Http\Api\Response\Builder\ApiResponseBuilder::class));
    }

    public function index(Request $request)
    {
        $perPage = (int) $request->get('per_page', 12);
        $filters = $request->only(['brand_id', 'car_type']);
        $paginator = $this->offerService->list($filters, $perPage);

        $hero = $this->offerCache->rememberHeroSetting('store_offers_hero');


        $offers = OfferResource::collection($paginator->items())->resolve();

        return $this->responseBuilder
            ->success(true)
            ->message('Offers retrieved successfully')
            ->data($offers)
            ->meta([
                'current_page' => $paginator->currentPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
                'last_page' => $paginator->lastPage(),
                'from' => $paginator->firstItem(),
                'to' => $paginator->lastItem(),
                'hero' => $hero,
            ])
            ->build();
    }
}
