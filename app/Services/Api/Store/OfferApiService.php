<?php

declare(strict_types=1);

namespace App\Services\Api\Store;

use App\Models\Offer;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

final class OfferApiService
{
    public function list(array $filters = [], int $perPage = 12): LengthAwarePaginator
    {
        $query = Offer::active()
            ->with(['car.brand' ,'car.highlight'])
            ->latest();

        if (! empty($filters['brand_id'])) {
            $query->whereHas('car', fn (Builder $q) => $q->where('brand_id', $filters['brand_id']));
        }

        if (! empty($filters['car_type'])) {
            $query->whereHas('car', fn (Builder $q) => $q->where('type', $filters['car_type']));
        }

        return $query->paginate($perPage);
    }
}
