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
            $q->where('slug->ar', $slug)
                ->orWhere('slug->en', $slug)
                ->orWhere('slug->ar', $decoded)
                ->orWhere('slug->en', $decoded)
                ->orWhere('slug', $slug)
                ->orWhere('slug', $decoded);

            if (is_numeric($slug)) {
                $q->orWhere('id', (int) $slug);
            }
        });
    }
}
