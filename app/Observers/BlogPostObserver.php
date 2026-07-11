<?php

namespace App\Observers;

use App\Models\BlogPost;
use App\Services\Cache\BlogCacheService;
use App\Services\Cache\HomeCacheService;

class BlogPostObserver
{
    public function __construct(
        private HomeCacheService $homeCache,
        private BlogCacheService $blogCache,
    ) {}

    public function saved(BlogPost $blogPost): void
    {
        $this->homeCache->forgetHome();
        $this->blogCache->forgetBlog();
    }

    public function deleted(BlogPost $blogPost): void
    {
        $this->homeCache->forgetHome();
        $this->blogCache->forgetBlog();
    }

    public function forceDeleted(BlogPost $blogPost): void
    {
        $this->homeCache->forgetHome();
        $this->blogCache->forgetBlog();
    }
}
