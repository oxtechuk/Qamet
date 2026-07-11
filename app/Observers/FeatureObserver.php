<?php

namespace App\Observers;

use App\Models\Feature;
use App\Services\Cache\HomeCacheService;

class FeatureObserver
{
    public function __construct(
        private HomeCacheService $homeCache,
    ) {}

    public function saved(Feature $feature): void
    {
        $this->homeCache->forgetHome();
    }

    public function deleted(Feature $feature): void
    {
        $this->homeCache->forgetHome();
    }
}
