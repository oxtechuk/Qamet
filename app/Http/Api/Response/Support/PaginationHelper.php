<?php

declare(strict_types=1);

namespace App\Http\Api\Response\Support;

use Illuminate\Pagination\LengthAwarePaginator;

final class PaginationHelper
{
    public static function extract(LengthAwarePaginator $paginator): array
    {
        return [
            'current_page' => $paginator->currentPage(),
            'per_page' => $paginator->perPage(),
            'total' => $paginator->total(),
            'last_page' => $paginator->lastPage(),
            'from' => $paginator->firstItem(),
            'to' => $paginator->lastItem(),
        ];
    }
}
