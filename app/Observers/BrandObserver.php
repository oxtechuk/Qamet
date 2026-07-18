<?php

namespace App\Observers;

use App\Models\Brand;
use App\Services\Cache\CarCacheService;
use App\Services\Cache\HomeCacheService;

class BrandObserver
{
    public function __construct(
        private HomeCacheService $homeCache,
        private CarCacheService $carCache,
    ) {}

    public function saved(Brand $brand): void
    {
        $this->homeCache->forgetBrands();
        $this->carCache->forgetCars();
    }

    public function deleted(Brand $brand): void
    {
        $this->homeCache->forgetBrands();
        $this->carCache->forgetCars();
    }

    public function forceDeleted(Brand $brand): void
    {
        $this->homeCache->forgetBrands();
        $this->carCache->forgetCars();
    }
}
