<?php

namespace App\Observers;

use App\Models\CarCategory;
use App\Services\Cache\CarCacheService;

class CarCategoryObserver
{
    public function __construct(
        private CarCacheService $carCache,
    ) {}

    public function saved(CarCategory $carCategory): void
    {
        $this->carCache->forgetCars();
    }

    public function deleted(CarCategory $carCategory): void
    {
        $this->carCache->forgetCars();
    }
}
