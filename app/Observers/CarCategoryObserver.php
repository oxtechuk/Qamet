<?php

namespace App\Observers;

use App\Models\CarCategory;
use App\Services\Cache\HomeCacheService;

class CarCategoryObserver
{
    public function __construct(
        private HomeCacheService $homeCache,
    ) {}

    public function saved(CarCategory $carCategory): void
    {
        $this->homeCache->forgetHome();
    }

    public function deleted(CarCategory $carCategory): void
    {
        $this->homeCache->forgetHome();
    }
}
