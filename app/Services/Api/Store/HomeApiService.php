<?php

declare(strict_types=1);

namespace App\Services\Api\Store;

use App\Http\Resources\Store\BrandResource;
use App\Http\Resources\Store\CarCardResource;
use App\Http\Resources\Store\HeroCarResource;
use App\Http\Resources\Store\OfferCardResource;
use App\Models\Car;
use App\Services\Cache\HomeCacheService;
use Illuminate\Support\Facades\Storage;

final class HomeApiService
{
    public function __construct(
        private readonly HomeCacheService $cache,
    ) {}

    public function home(): array
    {
        $locale = app()->getLocale();

        return [
            'hero_slides' => $this->buildHeroSlides($locale),
            'brands' => BrandResource::collection($this->cache->rememberBrands())->resolve(),
            'latest_cars' => [
                'section' => $this->sectionCopy('featured_cars', $locale),
                'items' => CarCardResource::collection($this->cache->rememberLatestCars())->resolve(),
            ],
            'why_us' => $this->buildWhyUs($locale),
            'campaign_banners' => $this->buildBanners($locale),
            'offers' => [
                'section' => $this->sectionCopy('offers', $locale),
                'items' => OfferCardResource::collection($this->cache->rememberOffers())->resolve(),
            ],
            'cars_by_budget' => $this->buildCarsByBudget($locale),
        ];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function buildHeroSlides(string $locale): array
    {
        $slides = $this->cache->rememberHomeHeroSlides();
        $carIds = array_values(array_filter(array_column($slides, 'car_id')));
        $cars = $carIds
            ? Car::whereIn('id', $carIds)->get()->keyBy('id')
            : collect();

        return collect($slides)
            ->filter(fn (array $slide): bool => $slide['is_active'] ?? true)
            ->map(function (array $slide) use ($cars, $locale): array {
                $car = isset($slide['car_id']) ? $cars->get($slide['car_id']) : null;

                return [
                    'image' => $this->resolveImage($slide['image'] ?? null),
                    'title' => $slide["title_{$locale}"] ?? $slide['title_en'] ?? '',
                    'car' => $car ? HeroCarResource::make($car)->resolve() : null,
                    'button_text' => $slide["button_text_{$locale}"] ?? $slide['button_text_en'] ?? '',
                    'button_link' => $slide['link'] ?? null,
                    'button_2_text' => $slide["button_2_text_{$locale}"] ?? $slide['button_2_text_en'] ?? '',
                    'button_2_link' => $slide['link_2'] ?? null,
                ];
            })
            ->values()
            ->all();
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function buildWhyUs(string $locale): array
    {
        return collect($this->cache->rememberWhyUs())
            ->map(fn (array $item): array => [
                'icon' => $item['icon'] ?? '',
                'title' => $item["title_{$locale}"] ?? $item['title_en'] ?? '',
                'description' => $item["description_{$locale}"] ?? $item['description_en'] ?? '',
            ])
            ->values()
            ->all();
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function buildBanners(string $locale): array
    {
        $raw = $this->cache->rememberBanner();

        if (empty($raw)) {
            return [];
        }

        // Legacy single-banner format
        if (isset($raw['image'])) {
            $raw = [$raw];
        }

        $now = now();

        return collect($raw)
            ->filter(fn (array $banner): bool => $banner['active'] ?? true)
            ->map(function (array $banner) use ($locale, $now): array {
                $startsAt = $banner['starts_at'] ?? null;
                $endsAt = $banner['ends_at'] ?? null;
                $withinDateRange = (! $startsAt || $now->gte($startsAt)) && (! $endsAt || $now->lte($endsAt));

                return [
                    'image' => $this->resolveImage($banner['image'] ?? null),
                    'mobile_image' => $this->resolveImage($banner['mobile_image'] ?? null),
                    'title' => $banner['title'][$locale] ?? $banner['title']['en'] ?? '',
                    'button_text' => $banner['button_text'][$locale] ?? $banner['button_text']['en'] ?? '',
                    'url' => $banner['url'] ?? null,
                    'is_active' => ($banner['active'] ?? true) && $withinDateRange,
                ];
            })
            ->values()
            ->all();
    }

    /**
     * @return array<string, mixed>
     */
    private function buildCarsByBudget(string $locale): array
    {
        $rawBrackets = $this->cache->rememberBudgetBrackets();

        $brackets = collect($rawBrackets)
            ->map(function (array $bracket) use ($locale): array {
                $min = (int) ($bracket['min'] ?? 0);
                $max = isset($bracket['max']) && $bracket['max'] !== null ? (int) $bracket['max'] : null;

                $count = Car::where('is_active', true)
                    ->where('cash_price', '>=', $min)
                    ->when($max !== null, fn ($q) => $q->where('cash_price', '<=', $max))
                    ->count();

                return [
                    'label' => $bracket["label_{$locale}"] ?? $bracket['label_en'] ?? '',
                    'min' => $min,
                    'max' => $max,
                    'count' => $count,
                ];
            })
            ->values();

        // Default cars shown before any bracket is selected — the first (lowest) bracket's range.
        $first = $brackets->first() ?? ['min' => 0, 'max' => null];
        $defaultCars = Car::where('is_active', true)
            ->where('cash_price', '>=', $first['min'])
            ->when($first['max'] !== null, fn ($q) => $q->where('cash_price', '<=', $first['max']))
            ->with(['brand', 'images', 'activeOffers'])
            ->latest()
            ->limit(8)
            ->get();

        return [
            'section' => $this->sectionCopy('budget', $locale),
            'brackets' => $brackets->all(),
            'cars' => CarCardResource::collection($defaultCars)->resolve(),
        ];
    }

    /**
     * @return array<string, string>
     */
    private function sectionCopy(string $key, string $locale): array
    {
        $rawSections = $this->cache->rememberSetting('homepage_sections', []);
        if (! is_array($rawSections)) {
            $rawSections = json_decode((string) $rawSections, true) ?: [];
        }

        $section = $rawSections[$key] ?? [];

        return [
            'badge' => $section['badge'][$locale] ?? '',
            'title' => $section['title'][$locale] ?? '',
            'subtitle' => $section['subtitle'][$locale] ?? '',
            'description' => $section['description'][$locale] ?? '',
            'button_text' => $section['button_text'][$locale] ?? '',
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
