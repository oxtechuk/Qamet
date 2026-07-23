<?php

namespace App\Observers;

use App\Models\Branch;
use App\Services\Cache\ContactCacheService;

class BranchObserver
{
    public function __construct(
        private ContactCacheService $contactCache,
    ) {}

    public function saved(Branch $branch): void
    {
        $this->contactCache->forgetContact();
    }

    public function deleted(Branch $branch): void
    {
        $this->contactCache->forgetContact();
    }
}
