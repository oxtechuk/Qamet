<?php

namespace App\Observers;

use App\Models\Car;
use App\Services\Cache\CalculatorCacheService;
use App\Services\Cache\CarCacheService;
use App\Services\Cache\HomeCacheService;
use App\Services\Cache\OfferCacheService;

class CarObserver
{
    public function __construct(
        private HomeCacheService $homeCache,
        private CarCacheService $carCache,
        private OfferCacheService $offerCache,
        private CalculatorCacheService $calculatorCache,
    ) {}

    public function saved(Car $car): void
    {
        $this->homeCache->forgetLatestCars();
        $this->homeCache->forgetBrands();
        $this->carCache->forgetCars();
        $this->offerCache->forgetOffers();
        $this->calculatorCache->forgetCalculator();
    }

    public function deleted(Car $car): void
    {
        $this->homeCache->forgetLatestCars();
        $this->homeCache->forgetBrands();
        $this->carCache->forgetCars();
        $this->offerCache->forgetOffers();
        $this->calculatorCache->forgetCalculator();
    }

    public function forceDeleted(Car $car): void
    {
        $this->homeCache->forgetLatestCars();
        $this->homeCache->forgetBrands();
        $this->carCache->forgetCars();
        $this->offerCache->forgetOffers();
        $this->calculatorCache->forgetCalculator();
    }
}
