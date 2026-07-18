<?php

namespace App\Observers;

use App\Models\GalleryItem;
use App\Services\Cache\AboutCacheService;

class GalleryItemObserver
{
    public function __construct(
        private AboutCacheService $aboutCache,
    ) {}

    public function saved(GalleryItem $galleryItem): void
    {
        $this->aboutCache->forgetGallery();
    }

    public function deleted(GalleryItem $galleryItem): void
    {
        $this->aboutCache->forgetGallery();
    }
}
