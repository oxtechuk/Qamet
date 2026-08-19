<?php

namespace App\Services\Cache;

use App\Models\Brand;
use App\Models\Car;
use App\Models\Offer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class HomeCacheService extends BaseCacheService
{
    /**
     * @return array<int, array<string, mixed>>
     */
    public function rememberHomeHeroSlides(): array
    {
        $slides = $this->rememberSetting('hero_slides', []);

        return is_array($slides) ? $slides : (json_decode((string) $slides, true) ?: []);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function rememberWhyUs(): array
    {
        $items = $this->rememberSetting('home_why_us', []);

        return is_array($items) ? $items : (json_decode((string) $items, true) ?: []);
    }

    /**
     * @return array<string, mixed>
     */
    public function rememberBanner(): array
    {
        $banner = $this->rememberSetting('home_banner', []);

        return is_array($banner) ? $banner : (json_decode((string) $banner, true) ?: []);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function rememberBudgetBrackets(): array
    {
        $brackets = $this->rememberSetting('home_budget_brackets', []);

        return is_array($brackets) ? $brackets : (json_decode((string) $brackets, true) ?: []);
    }

    public function rememberLatestCars(): Collection
    {
        return $this->remember('home.latest_cars', fn () => Car::with(['brand', 'images', 'activeOffers', 'highlight'])
            ->where('is_featured', true)
            ->where('is_active', true)
            ->latest()
            ->limit(8)
            ->get());
    }

    public function rememberOffers(): Collection
    {
        return $this->remember('home.offers', fn () => Offer::active()
            ->with('car.brand')
            ->limit(8)
            ->get());
    }

    public function rememberBrands(): Collection
    {
        return $this->remember('home.brands', fn () => Brand::where('is_active', true)
            ->withCount('cars')
            ->orderBy('name')
            ->get());
    }

    public function rememberDefaultBudgetCars(int $min = 0, ?int $max = null): Collection
    {
        $cacheKey = "home.budget_default_cars_{$min}_".($max ?? 'max');

        return $this->remember($cacheKey, fn () => Car::where('is_active', true)
            ->where('cash_price', '>=', $min)
            ->when($max !== null, fn ($q) => $q->where('cash_price', '<=', $max))
            ->with(['brand', 'images', 'activeOffers', 'highlight'])
            ->latest()
            ->limit(8)
            ->get());
    }

    public function rememberHeroCars(array $carIds): Collection
    {
        if (empty($carIds)) {
            return new Collection;
        }
        sort($carIds);
        $key = 'home.hero_cars_'.implode('_', $carIds);

        return $this->remember($key, fn () => Car::whereIn('id', $carIds)->get());
    }

    public function forgetLatestCars(): void
    {
        unset(self::$runtimeCache['home.latest_cars']);
        Cache::forget('home.latest_cars');
    }

    public function forgetOffers(): void
    {
        unset(self::$runtimeCache['home.offers']);
        Cache::forget('home.offers');
    }

    public function forgetBrands(): void
    {
        unset(self::$runtimeCache['home.brands']);
        Cache::forget('home.brands');
    }
}
