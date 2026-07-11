<?php

namespace App\Observers;

use App\Models\Partner;
use App\Services\Cache\HomeCacheService;

class PartnerObserver
{
    public function __construct(
        private HomeCacheService $homeCache,
    ) {}

    public function saved(Partner $partner): void
    {
        $this->homeCache->forgetHome();
    }

    public function deleted(Partner $partner): void
    {
        $this->homeCache->forgetHome();
    }
}
