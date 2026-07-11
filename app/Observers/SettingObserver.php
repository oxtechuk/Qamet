<?php

namespace App\Observers;

use App\Models\Setting;
use App\Services\Cache\BaseCacheService;
use App\Services\Cache\HomeCacheService;

class SettingObserver
{
    public function __construct(
        private BaseCacheService $baseCache,
        private HomeCacheService $homeCache,
    ) {}

    public function saved(Setting $setting): void
    {
        $this->baseCache->forgetSettings();
        $this->homeCache->forgetHome();
    }

    public function deleted(Setting $setting): void
    {
        $this->baseCache->forgetSettings();
        $this->homeCache->forgetHome();
    }
}
