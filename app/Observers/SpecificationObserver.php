<?php

namespace App\Observers;

use App\Models\Specification;
use App\Services\Cache\CarCacheService;

class SpecificationObserver
{
    public function __construct(
        private CarCacheService $carCache,
    ) {}

    public function saved(Specification $specification): void
    {
        $this->carCache->forgetCars();
    }

    public function deleted(Specification $specification): void
    {
        $this->carCache->forgetCars();
    }
}
