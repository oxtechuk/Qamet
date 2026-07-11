<?php

namespace App\Observers;

use App\Models\ProjectDesign;
use App\Services\Cache\HomeCacheService;

class ProjectDesignObserver
{
    public function __construct(
        private HomeCacheService $homeCache,
    ) {}

    public function saved(ProjectDesign $projectDesign): void
    {
        $this->homeCache->forgetHome();
    }

    public function deleted(ProjectDesign $projectDesign): void
    {
        $this->homeCache->forgetHome();
    }
}
