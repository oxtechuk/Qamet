<?php

declare(strict_types=1);

namespace App\Services\Api\Store;

use App\Models\Partner;

final class PartnerApiService
{
    public function list(): \Illuminate\Database\Eloquent\Collection
    {
        return Partner::orderBy('sort_order')
            ->get();
    }
}
