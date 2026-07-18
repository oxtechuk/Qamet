<?php

declare(strict_types=1);

namespace App\Services\Api\Store;

use App\Http\Resources\Store\GalleryItemResource;
use App\Services\Cache\AboutCacheService;

final class GalleryApiService
{
    public function __construct(
        private readonly AboutCacheService $cache,
    ) {}

    public function gallery(): array
    {
        return GalleryItemResource::collection($this->cache->rememberGallery())->resolve();
    }
}
