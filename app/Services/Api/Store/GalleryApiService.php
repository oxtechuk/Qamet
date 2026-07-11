<?php

declare(strict_types=1);

namespace App\Services\Api\Store;

use App\Services\Cache\BaseCacheService;
use Illuminate\Support\Facades\Storage;

final class GalleryApiService
{
    public function __construct(
        private readonly BaseCacheService $cache,
    ) {}

    public function gallery(): array
    {
        $gallery = $this->cache->rememberSetting('main_gallery');

        $items = is_array($gallery) ? $gallery : [];

        return array_map(fn ($path) => $this->resolveUrl($path), $items);
    }

    private function resolveUrl(?string $path): ?string
    {
        if ($path === null) {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        return Storage::disk('public')->url($path);
    }
}
