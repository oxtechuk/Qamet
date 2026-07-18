<?php

namespace App\Observers;

use App\Models\CoreValue;
use App\Services\Cache\AboutCacheService;

class CoreValueObserver
{
    public function __construct(
        private AboutCacheService $aboutCache,
    ) {}

    public function saved(CoreValue $coreValue): void
    {
        $this->aboutCache->forgetCoreValues();
    }

    public function deleted(CoreValue $coreValue): void
    {
        $this->aboutCache->forgetCoreValues();
    }
}
