<?php

namespace App\Observers;

use App\Models\Testimonial;
use App\Services\Cache\HomeCacheService;

class TestimonialObserver
{
    public function __construct(
        private HomeCacheService $homeCache,
    ) {}

    public function saved(Testimonial $testimonial): void
    {
        $this->homeCache->forgetHome();
    }

    public function deleted(Testimonial $testimonial): void
    {
        $this->homeCache->forgetHome();
    }
}
