<?php

declare(strict_types=1);

namespace App\Services\Api\Store\Helpers;

use Illuminate\Database\Eloquent\Builder;

final class SlugResolver
{
    public static function applyCarSlug(Builder $query, string $slug): void
    {
        $query->where(function ($q) use ($slug) {
            $q->where('slug->en', $slug)->orWhere('slug->ar', $slug);
        });
    }
}
