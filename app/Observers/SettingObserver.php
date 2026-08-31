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

        \App\Services\ActivityLog\ActivityLogger::log(
            action: 'updated',
            subjectType: 'إعدادات النظام',
            subjectId: $setting->id,
            subjectTitle: (string) $setting->key,
            description: "قام بتحديث إعداد النظام: [{$setting->key}]"
        );
    }

    public function deleted(Setting $setting): void
    {
        $this->baseCache->forgetSettings();
        $this->offerCache->forgetOffers();

        \App\Services\ActivityLog\ActivityLogger::log(
            action: 'deleted',
            subjectType: 'إعدادات النظام',
            subjectId: $setting->id,
            subjectTitle: (string) $setting->key,
            description: "قام بحذف إعداد النظام: [{$setting->key}]"
        );
    }
}
