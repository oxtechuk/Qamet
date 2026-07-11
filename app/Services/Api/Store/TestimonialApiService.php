<?php

declare(strict_types=1);

namespace App\Services\Api\Store;

use App\Models\Testimonial;

final class TestimonialApiService
{
    public function list(): \Illuminate\Database\Eloquent\Collection
    {
        return Testimonial::where('is_visible', true)
            ->get();
    }
}
