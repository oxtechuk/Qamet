<?php

namespace App\Services\Cache;

use App\Models\CalculatorBank;
use App\Models\CalculatorFactor;
use App\Models\Car;
use Illuminate\Support\Facades\Cache;

class CalculatorCacheService extends BaseCacheService
{
    public function rememberCalculatorData(): array
    {
        return $this->remember('calculator.data', function () {
            $banks = CalculatorBank::query()->activeOrdered()->get();
            $factors = CalculatorFactor::query()->activeOrdered()->get()->groupBy('type');

            $cars = Car::query()
                ->with('brand')
                ->where('is_active', true)
                ->orderByDesc('id')
                ->get();

            return compact('banks', 'factors', 'cars');
        });
    }

    public function forgetCalculator(): void
    {
        Cache::forget('calculator.data');
    }
}
