<?php

declare(strict_types=1);

namespace App\Services\Api\Store\Helpers;

use Illuminate\Database\Eloquent\Builder;

final class SlugResolver
{
    public static function applyCarSlug(Builder $query, string $slug): void
    {
        $decoded = urldecode($slug);

        $query->where(function ($q) use ($slug, $decoded) {
            $q->where('slug->en', $slug)
                ->orWhere('slug->ar', $slug)
                ->orWhere('slug->en', $decoded)
                ->orWhere('slug->ar', $decoded);

            if (strlen($decoded) > 10) {
                $prefix = mb_substr($decoded, 0, 15);
                $q->orWhere('slug->ar', 'LIKE', "%{$prefix}%")
                    ->orWhere('slug->en', 'LIKE', "%{$prefix}%");
            }
        });
    }
}
