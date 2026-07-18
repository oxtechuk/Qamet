<?php

namespace App\Observers;

use App\Models\WhyChooseUsItem;
use App\Services\Cache\AboutCacheService;

class WhyChooseUsItemObserver
{
    public function __construct(
        private AboutCacheService $aboutCache,
    ) {}

    public function saved(WhyChooseUsItem $whyChooseUsItem): void
    {
        $this->aboutCache->forgetWhyChooseUs();
    }

    public function deleted(WhyChooseUsItem $whyChooseUsItem): void
    {
        $this->aboutCache->forgetWhyChooseUs();
    }
}
