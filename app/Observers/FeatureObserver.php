<?php

namespace App\Observers;

use App\Models\Feature;
use App\Services\Cache\CarCacheService;

class FeatureObserver
{
    public function __construct(
        private CarCacheService $carCache,
    ) {}

    public function saved(Feature $feature): void
    {
        $this->carCache->forgetCars();
    }

    public function deleted(Feature $feature): void
    {
        $this->carCache->forgetCars();
    }
}
