<?php

namespace App\Observers;

use App\Models\Testimonial;
use App\Services\Cache\AboutCacheService;

class TestimonialObserver
{
    public function __construct(
        private AboutCacheService $aboutCache,
    ) {}

    public function saved(Testimonial $testimonial): void
    {
        $this->aboutCache->forgetTestimonials();
    }

    public function deleted(Testimonial $testimonial): void
    {
        $this->aboutCache->forgetTestimonials();
    }
}
