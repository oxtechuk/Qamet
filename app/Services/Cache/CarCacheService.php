<?php

namespace App\Services\Cache;

use App\Models\Brand;
use App\Models\BrandType;
use App\Models\Car;
use App\Models\CarCategory;
use App\Models\CarType;
use Illuminate\Support\Facades\Cache;

class CarCacheService extends BaseCacheService
{
    public function rememberCarFilters(): array
    {
        $result = $this->remember('cars.filters', function () {
            $brands = Brand::whereHas('cars', fn ($q) => $q->where('is_active', true))
                ->withCount(['cars' => fn ($q) => $q->where('is_active', true)])
                ->orderBy('name')
                ->get();

            $years = Car::where('is_active', true)->distinct()->orderByDesc('year')->pluck('year');

            $types = CarType::where('is_active', true)->orderBy('sort_order')->orderBy('id')->get();

            $categories = CarCategory::where('is_active', true)->orderBy('sort_order')->orderBy('id')->get();

            $brandTypes = BrandType::where('is_active', true)->orderBy('sort_order')->orderBy('id')->get();

            $carPrices = Car::where('is_active', true)->pluck('cash_price');
            $priceBrackets = [
                ['min' => 0, 'max' => 150000],
                ['min' => 150001, 'max' => 250000],
                ['min' => 250001, 'max' => 350000],
                ['min' => 350001, 'max' => null],
            ];
            $prices = collect($priceBrackets)->map(function (array $bracket) use ($carPrices): array {
                $count = $carPrices->filter(
                    fn (int $price): bool => $price >= $bracket['min']
                        && ($bracket['max'] === null || $price <= $bracket['max'])
                )->count();

                return [
                    'min' => $bracket['min'],
                    'max' => $bracket['max'],
                    'count' => $count,
                ];
            })->values()->all();

            $activeCars = Car::where('is_active', true)->get(['id', 'specs']);

            $fuels = $activeCars->pluck('specs.fuel')
                ->filter()
                ->countBy()
                ->map(fn (int $count, string $fuel): array => ['value' => $fuel, 'count' => $count])
                ->values()
                ->all();

            $horsepowers = $activeCars->pluck('horsepower')->filter();
            $hpBrackets = [
                ['min' => 0, 'max' => 150],
                ['min' => 151, 'max' => 250],
                ['min' => 251, 'max' => 350],
                ['min' => 351, 'max' => null],
            ];
            $horsepowerBrackets = collect($hpBrackets)->map(function (array $bracket) use ($horsepowers): array {
                $count = $horsepowers->filter(
                    fn (int $hp): bool => $hp >= $bracket['min']
                        && ($bracket['max'] === null || $hp <= $bracket['max'])
                )->count();

                return [
                    'min' => $bracket['min'],
                    'max' => $bracket['max'],
                    'count' => $count,
                ];
            })->values()->all();

            $highlightCounts = Car::where('is_active', true)
                ->where('is_highlighted', '!=', 'none')
                ->pluck('is_highlighted')
                ->countBy()
                ->all();

            return compact('brands', 'years', 'types', 'categories', 'brandTypes', 'prices', 'fuels', 'horsepowerBrackets', 'highlightCounts');
        }, self::TTL_LONG);

        $locale = app()->getLocale();
        $result['highlights'] = collect(Car::HIGHLIGHT_OPTIONS)->map(fn (array $labels, string $value): array => [
            'value' => $value,
            'label' => $labels[$locale] ?? $labels['en'],
            'count' => $result['highlightCounts'][$value] ?? 0,
        ])->values()->all();

        return $result;
    }

    public function rememberTotalActiveCars(): int
    {
        return (int) $this->remember('cars.total_active', fn () => Car::where('is_active', true)->count(), self::TTL_DEFAULT);
    }

    public function rememberTotalActiveBrands(): int
    {
        return (int) $this->remember('brands.total_active', fn () => Brand::where('is_active', true)->count(), self::TTL_DEFAULT);
    }

    public function rememberFeaturedOffer(): mixed
    {
        return $this->remember('offers.featured', fn () => \App\Models\Offer::active()->with('car.brand')->first(), self::TTL_DEFAULT);
    }

    public function rememberAllCarPrices(): \Illuminate\Support\Collection
    {
        return $this->remember('cars.all_prices', fn () => Car::where('is_active', true)->pluck('cash_price'), self::TTL_LONG);
    }

    public function forgetCars(): void
    {
        unset(
            self::$runtimeCache['cars.filters'],
            self::$runtimeCache['cars.total_active'],
            self::$runtimeCache['brands.total_active'],
            self::$runtimeCache['offers.featured'],
            self::$runtimeCache['cars.all_prices']
        );
        Cache::forget('cars.filters');
        Cache::forget('cars.total_active');
        Cache::forget('brands.total_active');
        Cache::forget('offers.featured');
        Cache::forget('cars.all_prices');
    }
}
