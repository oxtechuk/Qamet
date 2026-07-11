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
                ->with(['cars.brand'])
                ->latest()
                ->paginate(12);

            $bentoCars = Car::where('is_active', true)
                ->where(function ($q) {
                    $q->where('is_featured', true)->orWhereHas('offers');
                })
                ->with(['brand', 'offers'])
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

            return compact('offers', 'bentoCars', 'mainGallery');
        });
    }

    public function forgetOffers(): void
    {
        Cache::forget('offers.data');
    }
}
