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

    public function rememberOffersHeroOffer(): ?array
    {
        return $this->remember('offers.hero_offer', function () {
            $offerId = $this->rememberSetting('offers_hero_offer_id');

            if (! $offerId) {
                return null;
            }

            $offer = Offer::with(['car.brand'])->find($offerId);

            if (! $offer || ! $offer->is_active) {
                return null;
            }

            $endsAt = $offer->ends_at;
            $remaining = null;

            if ($endsAt && $endsAt->isFuture()) {
                $now = now();
                $diff = $now->diff($endsAt);
                $remaining = [
                    'days' => $diff->days,
                    'hours' => $diff->h,
                    'minutes' => $diff->i,
                    'seconds' => $diff->s,
                    'total_seconds' => (int) $now->diffInSeconds($endsAt),
                ];
            }

            return [
                'id' => $offer->id,
                'title' => $offer->title,
                'description' => $offer->description,
                'image' => $offer->image,
                'discount_percent' => $offer->discount_percent,
                'special_price' => $offer->special_price,
                'special_installment' => $offer->special_installment,
                'ends_at' => $endsAt?->toISOString(),
                'is_expired' => $offer->is_expired,
                'remaining' => $remaining,
                'car' => $offer->car ? [
                    'id' => $offer->car->id,
                    'name' => $offer->car->name,
                    'slug' => $offer->car->slug,
                    'thumbnail' => \App\Casts\AsImageUrl::url($offer->car->thumbnail),
                    'cash_price' => $offer->car->cash_price,
                    'brand' => $offer->car->brand?->name,
                ] : null,
            ];
        }, self::TTL_DEFAULT);
    }

    public function forgetOffers(): void
    {
        Cache::forget('offers.data');
        Cache::forget('offers.hero_slides');
        Cache::forget('offers.hero_offer');
    }
}
