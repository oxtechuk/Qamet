<?php

namespace App\Http\Controllers\Api\Store;

use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Resources\Store\BrandResource;
use App\Http\Resources\Store\BrandTypeResource;
use App\Http\Resources\Store\CarCategoryResource;
use App\Http\Resources\Store\CarMiniResource;
use App\Http\Resources\Store\CarResource;
use App\Http\Resources\Store\CarTypeResource;
use App\Http\Resources\Store\HomeOfferResource;
use App\Services\Api\Store\CarApiService;
use App\Services\Api\Store\CompareApiService;
use Illuminate\Http\Request;

final class CarController extends ApiBaseController
{
    public function __construct(
        private readonly CarApiService $carService,
        private readonly CompareApiService $compareService,
    ) {
        parent::__construct(app(\App\Http\Api\Response\Builder\ApiResponseBuilder::class));
    }

    public function listMeta()
    {
        $result = $this->carService->listMeta();
        $offer = $result['featuredOffer'];

        $featuredOffer = null;
        if ($offer) {
            $featuredOffer = HomeOfferResource::make($offer)->resolve();
        }

        return $this->respondSuccess([
            'featured_offer' => $featuredOffer,
            'total_cars' => $result['totalCars'],
            'total_brands' => $result['totalBrands'],
            'filter_brands' => BrandResource::collection($result['filterBrands'])->resolve(),
            'filter_types' => CarTypeResource::collection($result['filterTypes'])->resolve(),
            'filter_categories' => CarCategoryResource::collection($result['filterCategories'])->resolve(),
            'filter_brand_types' => BrandTypeResource::collection($result['filterBrandTypes'])->resolve(),
            'filter_years' => $result['filterYears'],
            'filter_prices' => $result['filterPrices'],
            'filter_fuels' => $result['filterFuels'],
            'filter_horsepowers' => $result['filterHorsepowers'],
            'filter_highlights' => $result['filterHighlights'],
            'homepage_stats' => $result['homepageStats'],
            'hero' => $result['hero'],
            'hero_slides' => $result['heroSlides'],
            'hero_ads' => $result['heroAds'],
        ], 'Listing meta retrieved successfully');
    }

    public function index(Request $request)
    {
        $filters = $request->only(['brands', 'type', 'year', 'min_price', 'max_price', 'search', 'q', 'offer_id', 'sort', 'category_id', 'brand_type_id', 'fuel', 'min_hp', 'max_hp', 'highlight']);
        $paginator = $this->carService->list($filters, (int) $request->get('per_page', 12));

        $paginator->setCollection(collect(
            CarMiniResource::collection($paginator->items())->resolve()
        ));

        return $this->respondPaginated($paginator, 'Cars retrieved successfully');
    }

    public function show(string $slug)
    {
        $result = $this->carService->findBySlug($slug);
        $result['car']->setRelation('relatedCars', $result['relatedCars']);

        return $this->respondSuccess(
            CarResource::make($result['car'])->resolve(),
            'Car retrieved successfully'
        );
    }

    public function search(Request $request)
    {
        $query = $request->get('q', '');

        return $this->respondSuccess(
            CarMiniResource::collection($this->carService->search($query))->resolve(),
            $query ? 'Search results' : 'All cars'
        );
    }

    public function compare(Request $request)
    {
        $slugs = array_filter(array_slice((array) $request->get('cars', []), 0, 3));

        if (count($slugs) < 2) {
            return $this->respondError('Please provide at least 2 car slugs to compare', 422);
        }

        return $this->respondSuccess(
            $this->compareService->compare($slugs),
            'Comparison retrieved successfully'
        );
    }

    public function brands()
    {
        return $this->respondSuccess(
            BrandResource::collection($this->carService->brands())->resolve(),
            'Brands retrieved successfully'
        );
    }
}
