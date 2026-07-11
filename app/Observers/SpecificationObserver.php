<?php

namespace App\Observers;

use App\Models\Specification;
use App\Services\Cache\HomeCacheService;

class SpecificationObserver
{
    public function __construct(
        private HomeCacheService $homeCache,
    ) {}

    public function saved(Specification $specification): void
    {
        $this->homeCache->forgetHome();
    }

    public function deleted(Specification $specification): void
    {
        $this->homeCache->forgetHome();
    }
}
