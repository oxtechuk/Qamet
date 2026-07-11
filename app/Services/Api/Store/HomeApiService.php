<?php

declare(strict_types=1);

namespace App\Services\Api\Store;

use App\Http\Resources\Store\CarMiniResource;
use App\Http\Resources\Store\HomeOfferResource;
use App\Models\Car;
use App\Models\Offer;
use App\Services\Cache\HomeCacheService;
use Illuminate\Support\Facades\Storage;

final class HomeApiService
{
    public function __construct(
        private readonly HomeCacheService $cache,
    ) {}

    public function home(): array
    {
        $data = $this->cache->rememberHomeData();

        $heroSlides = array_map(function (array $slide): array {
            $slide['image'] = $this->resolveImage($slide['image'] ?? null);

            return $slide;
        }, $data['heroSlides'] ?? []);

        $featuredSetting = $this->cache->rememberSetting('homepage_featured', []);
        $homepageStats = $this->cache->rememberSetting('homepage_stats', []);
        if (! is_array($homepageStats)) {
            $homepageStats = json_decode((string) $homepageStats, true) ?: [];
        }

        $rawSections = $this->cache->rememberSetting('homepage_sections', []);
        if (! is_array($rawSections)) {
            $rawSections = json_decode((string) $rawSections, true) ?: [];
        }

        $hero = $this->cache->rememberHeroSetting('store_home_hero');

        $locale = app()->getLocale();
        $carId = $featuredSetting['car_id'] ?? null;
        $offerId = $featuredSetting['offer_id'] ?? null;

        $featuredSection = [
            'title' => $featuredSetting['title'][$locale] ?? '',
            'description' => $featuredSetting['description'][$locale] ?? '',
            'car' => $carId ? CarMiniResource::make(Car::with('brand', 'images')->find($carId))->resolve() : null,
            'offer' => $offerId ? HomeOfferResource::make(Offer::query()->find($offerId))->resolve() : null,
        ];

        $pageSections = [
            'filter' => [
                'title' => $rawSections['filter']['title'][$locale] ?? '',
            ],
            'featured_cars' => [
                'badge' => $rawSections['featured_cars']['badge'][$locale] ?? '',
                'title' => $rawSections['featured_cars']['title'][$locale] ?? '',
                'subtitle' => $rawSections['featured_cars']['subtitle'][$locale] ?? '',
                'button_text' => $rawSections['featured_cars']['button_text'][$locale] ?? '',
            ],
            'offers' => [
                'badge' => $rawSections['offers']['badge'][$locale] ?? '',
                'title' => $rawSections['offers']['title'][$locale] ?? '',
                'button_text' => $rawSections['offers']['button_text'][$locale] ?? '',
            ],
            'highlighted_cars' => [
                'badge' => $rawSections['highlighted_cars']['badge'][$locale] ?? '',
                'title' => $rawSections['highlighted_cars']['title'][$locale] ?? '',
                'subtitle' => $rawSections['highlighted_cars']['subtitle'][$locale] ?? '',
                'button_text' => $rawSections['highlighted_cars']['button_text'][$locale] ?? '',
            ],
            'finance' => [
                'title' => $rawSections['finance']['title'][$locale] ?? '',
                'subtitle' => $rawSections['finance']['subtitle'][$locale] ?? '',
                'features' => array_values(array_filter(array_map('trim', explode("\n", $rawSections['finance']['features'][$locale] ?? '')))),
                'button_text' => $rawSections['finance']['button_text'][$locale] ?? '',
            ],
            'brands' => [
                'title' => $rawSections['brands']['title'][$locale] ?? '',
                'subtitle' => $rawSections['brands']['subtitle'][$locale] ?? '',
            ],
            'budget' => [
                'badge' => $rawSections['budget']['badge'][$locale] ?? '',
                'title' => $rawSections['budget']['title'][$locale] ?? '',
                'description' => $rawSections['budget']['description'][$locale] ?? '',
                'button_text' => $rawSections['budget']['button_text'][$locale] ?? '',
            ],
        ];

        return [
            'hero' => $hero,
            'featured_cars' => ($data['featuredCars'] ?? collect())->values(),
            'active_offers' => ($data['activeOffers'] ?? collect())->values(),
            'brands' => ($data['brands'] ?? collect())->values(),
            'latest_posts' => ($data['latestPosts'] ?? collect())->values(),
            'stats' => $data['stats'] ?? [],
            'testimonials' => ($data['testimonials'] ?? collect())->values(),
            'partners' => ($data['partners'] ?? collect())->values(),
            'filter_brands' => ($data['filterBrands'] ?? collect())->values(),
            'filter_categories' => ($data['filterCategories'] ?? collect())->values(),
            'filter_types' => ($data['filterTypes'] ?? collect())->values(),
            'filter_years' => ($data['filterYears'] ?? collect())->values(),
            'filter_prices' => ($data['filterPrices'] ?? collect())->values(),
            'filter_fuels' => ($data['filterFuels'] ?? collect())->values(),
            'filter_horsepowers' => ($data['filterHorsepowers'] ?? collect())->values(),
            'filter_highlights' => ($data['filterHighlights'] ?? collect())->values(),
            'filter_brand_types' => ($data['filterBrandTypes'] ?? collect())->values(),
            'bento_cars' => ($data['bentoCars'] ?? collect())->values(),
            'highlighted_cars' => ($data['highlightedCars'] ?? collect())->values(),
            'hero_slides' => $heroSlides,
            'featured_section' => $featuredSection,
            'homepage_stats' => $homepageStats,
            'page_sections' => $pageSections,
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
}
