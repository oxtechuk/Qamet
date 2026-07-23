<?php

namespace App\Observers;

use App\Models\Setting;
use App\Services\Cache\BaseCacheService;
use App\Services\Cache\OfferCacheService;

class SettingObserver
{
    public function __construct(
        private BaseCacheService $baseCache,
        private OfferCacheService $offerCache,
    ) {}

    public function saved(Setting $setting): void
    {
        $this->baseCache->forgetSettings();
        $this->offerCache->forgetOffers();
    }

    public function deleted(Setting $setting): void
    {
        $this->baseCache->forgetSettings();
        $this->offerCache->forgetOffers();
    }
}
