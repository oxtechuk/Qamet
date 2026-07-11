<?php

declare(strict_types=1);

namespace App\Services\Api\Store;

use App\Models\CarCategory;

final class CarCategoryApiService
{
    public function list(): \Illuminate\Database\Eloquent\Collection
    {
        return CarCategory::activeOrdered()
            ->withCount('cars')
            ->get();
    }
}
