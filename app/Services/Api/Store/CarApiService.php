<?php

declare(strict_types=1);

namespace App\Services\Api\Store;

use App\Models\Brand;
use App\Models\Car;
use App\Services\Api\Store\Helpers\SlugResolver;
use App\Services\Cache\CarCacheService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;

final class CarApiService
{
    public function __construct(
        private readonly CarCacheService $cache,
    ) {}

    public function list(array $filters, int $perPage = 12): LengthAwarePaginator
    {
        $query = Car::with(['brand', 'category', 'images', 'activeOffers', 'highlight'])->where('is_active', true);

        $this->applyFilters($query, $filters);
        $this->applySorting($query, $filters['sort'] ?? 'latest');

        return $query->paginate($perPage)->withQueryString();
    }

    public function findBySlug(string $slug): array
    {
        $query = Car::with([
            'brand',
            'category',
            'images',
            'specifications',
            'features_list',
            'safety_features',
            'activeOffers',
            'highlight',
            'offers' => fn ($q) => $q->active(),
        ])
            ->where('is_active', true);

        SlugResolver::applyCarSlug($query, $slug);

        $car = $query->first();

        if (! $car) {
            throw new ModelNotFoundException('Car not found');
        }

        $car->increment('views');

        $relatedCars = Car::with(['brand', 'category', 'images', 'activeOffers', 'highlight'])
            ->where('brand_id', $car->brand_id)
            ->where('id', '!=', $car->id)
            ->where('is_active', true)
            ->limit(4)
            ->get();

        return compact('car', 'relatedCars');
    }

    public function search(string $query): \Illuminate\Database\Eloquent\Collection
    {
        return Car::with(['brand', 'category', 'images', 'highlight'])
            ->where('is_active', true)
            ->where(function ($q) use ($query) {
                $q->where('name->ar', 'LIKE', "%{$query}%")
                    ->orWhere('name->en', 'LIKE', "%{$query}%")
                    ->orWhereHas('brand', fn ($bq) => $bq->where('name', 'LIKE', "%{$query}%"))
                    ->orWhere('model', 'LIKE', "%{$query}%")
                    ->orWhere('year', 'LIKE', "%{$query}%");
            })
            ->orderByDesc('is_featured')
            ->limit(8)
            ->get();
    }

    public function brands(): \Illuminate\Database\Eloquent\Collection
    {
        return Brand::where('is_active', true)
            ->when(request('search'), function (Builder $q) {
                $search = request('search');
                $q->where(function (Builder $q) use ($search) {
                    $q->where('name->ar', 'LIKE', "%{$search}%")
                        ->orWhere('name->en', 'LIKE', "%{$search}%");
                });
            })
            ->when(request('brand_type_id'), function (Builder $q) {
                $q->where('brand_type_id', request('brand_type_id'));
            })
            ->withCount('cars')
            ->get();
    }

    public function listMeta(): array
    {
        $featuredOffer = $this->cache->rememberFeaturedOffer();
        $totalCars = $this->cache->rememberTotalActiveCars();
        $totalBrands = $this->cache->rememberTotalActiveBrands();

        $hero = $this->cache->rememberHeroSetting('store_hero');

        $filters = $this->cache->rememberCarFilters();

        $homepageStats = $this->cache->rememberSetting('homepage_stats', []);
        if (! is_array($homepageStats)) {
            $homepageStats = json_decode((string) $homepageStats, true) ?: [];
        }

        $heroSlides = array_map(function (array $slide): array {
            $slide['image'] = $this->resolveImage($slide['image'] ?? null);

            return $slide;
        }, $this->cache->rememberHeroSlides());

        $carHeroSlides = array_map(function (array $slide): array {
            $slide['image'] = $this->resolveImage($slide['image'] ?? null);

            return $slide;
        }, $this->cache->rememberCarHeroSlides());

        $heroAds = [
            [
                'image' => $this->resolveImage($this->cache->rememberSetting('hero_ad_1_image')),
                'link' => $this->cache->rememberSetting('hero_ad_1_link', ''),
            ],
            [
                'image' => $this->resolveImage($this->cache->rememberSetting('hero_ad_2_image')),
                'link' => $this->cache->rememberSetting('hero_ad_2_link', ''),
            ],
        ];

        return [
            'featuredOffer' => $featuredOffer,
            'totalCars' => $totalCars,
            'totalBrands' => $totalBrands,
            'filterBrands' => $filters['brands'],
            'filterTypes' => $filters['types'],
            'filterCategories' => $filters['categories'],
            'filterBrandTypes' => $filters['brandTypes'],
            'filterYears' => $filters['years'],
            'filterPrices' => $filters['prices'],
            'filterFuels' => $filters['fuels'],
            'filterHorsepowers' => $filters['horsepowerBrackets'],
            'filterHighlights' => $filters['highlights'],
            'homepageStats' => $homepageStats,
            'hero' => $hero,
            'heroSlides' => $heroSlides,
            'carHeroSlides' => $carHeroSlides,
            'heroAds' => $heroAds,
        ];
    }

    private function resolveImage(?string $path): ?string
    {
        if ($path === null) {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        return Storage::disk('public')->url($path);
    }

    private function applyFilters(Builder $query, array $filters): void
    {
        if (! empty($filters['brands'])) {
            $brands = is_array($filters['brands']) ? $filters['brands'] : [$filters['brands']];
            $query->whereIn('brand_id', $brands);
        }

        if (! empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (! empty($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        if (! empty($filters['brand_type_id'])) {
            $query->whereHas('brand', fn (Builder $q) => $q->where('brand_type_id', $filters['brand_type_id']));
        }

        if (! empty($filters['year'])) {
            $query->where('year', $filters['year']);
        }

        if (! empty($filters['min_price'])) {
            $query->where('cash_price', '>=', $filters['min_price']);
        }

        if (! empty($filters['max_price'])) {
            $query->where('cash_price', '<=', $filters['max_price']);
        }

        if (! empty($filters['fuel'])) {
            $query->where('specs->fuel', $filters['fuel']);
        }

        if (! empty($filters['highlight'])) {
            $query->where('is_highlighted', $filters['highlight']);
        }

        if (! empty($filters['min_hp']) || ! empty($filters['max_hp'])) {
            $minHp = ! empty($filters['min_hp']) ? (int) $filters['min_hp'] : null;
            $maxHp = ! empty($filters['max_hp']) ? (int) $filters['max_hp'] : null;

            $matchingIds = Car::where('is_active', true)
                ->get(['id', 'specs'])
                ->pluck('horsepower', 'id')
                ->filter(fn (?int $hp): bool => $hp !== null
                    && ($minHp === null || $hp >= $minHp)
                    && ($maxHp === null || $hp <= $maxHp))
                ->keys();

            $query->whereIn('id', $matchingIds);
        }

        $search = $filters['search'] ?? $filters['q'] ?? null;

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('model', 'like', "%{$search}%")
                    ->orWhereHas('brand', fn ($b) => $b->where('name', 'like', "%{$search}%"));
            });
        }

        if (! empty($filters['offer_id'])) {
            $query->whereHas('offers', fn ($q) => $q->where('offers.id', $filters['offer_id']));
        }
    }

    private function applySorting(Builder $query, string $sort): void
    {
        match ($sort) {
            'price_asc' => $query->orderBy('cash_price'),
            'price_desc' => $query->orderByDesc('cash_price'),
            'year_desc' => $query->orderByDesc('year'),
            default => $query->latest('id'),
        };
    }
}
