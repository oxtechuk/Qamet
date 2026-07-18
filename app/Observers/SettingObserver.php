<?php

namespace App\Observers;

use App\Models\Setting;
use App\Services\Cache\BaseCacheService;

class SettingObserver
{
    public function __construct(
        private BaseCacheService $baseCache,
    ) {}

    public function saved(Setting $setting): void
    {
        $this->baseCache->forgetSettings();
    }

    public function deleted(Setting $setting): void
    {
        $this->baseCache->forgetSettings();
    }
}
