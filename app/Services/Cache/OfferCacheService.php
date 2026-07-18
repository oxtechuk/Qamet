<?php

namespace App\Services\Cache;

use App\Models\Car;
use App\Models\Offer;
use Illuminate\Support\Facades\Cache;

class OfferCacheService extends BaseCacheService
{
    public function rememberOffersData(): array
    {
        return $this->remember('offers.data', function () {
            $offers = Offer::active()
                ->with(['car.brand'])
                ->latest()
                ->paginate(12);

            $bentoCars = Car::where('is_active', true)
                ->where(function ($q) {
                    $q->where('is_featured', true)->orWhereHas('offers');
                })
                ->with(['brand', 'images', 'activeOffers'])
                ->latest()
                ->take(5)
                ->get();

            $settings = $this->rememberSettings();
            $mainGallery = [];
            if (isset($settings['main_gallery'])) {
                $mainGallery = is_array($settings['main_gallery'])
                    ? $settings['main_gallery']
                    : (json_decode($settings['main_gallery'], true) ?: []);
            }

            $offerHeroSlides = $settings['offer_hero_slides'] ?? [];
            if (is_string($offerHeroSlides)) {
                $offerHeroSlides = json_decode($offerHeroSlides, true) ?: [];
            }

            return compact('offers', 'bentoCars', 'mainGallery', 'offerHeroSlides');
        });
    }

    public function rememberOfferHeroSlides(): array
    {
        return $this->remember('offers.hero_slides', function () {
            $settings = $this->rememberSettings();
            $slides = $settings['offer_hero_slides'] ?? [];
            if (is_string($slides)) {
                $slides = json_decode($slides, true) ?: [];
            }

            return array_map(function (array $slide): array {
                if (isset($slide['image']) && is_string($slide['image']) && ! str_starts_with($slide['image'], 'http')) {
                    $slide['image'] = \Illuminate\Support\Facades\Storage::disk('public')->url($slide['image']);
                }

                return $slide;
            }, $slides);
        }, self::TTL_LONG);
    }

    public function forgetOffers(): void
    {
        Cache::forget('offers.data');
        Cache::forget('offers.hero_slides');
    }
}
