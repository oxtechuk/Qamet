<?php

namespace App\Observers;

use App\Models\BlogPost;
use App\Services\Cache\BlogCacheService;

class BlogPostObserver
{
    public function __construct(
        private BlogCacheService $blogCache,
    ) {}

    public function saved(BlogPost $blogPost): void
    {
        $this->blogCache->forgetBlog();
    }

    public function deleted(BlogPost $blogPost): void
    {
        $this->blogCache->forgetBlog();
    }

    public function forceDeleted(BlogPost $blogPost): void
    {
        $this->blogCache->forgetBlog();
    }
}
