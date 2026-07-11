<?php

declare(strict_types=1);

namespace App\Services\Api\Store;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Services\Cache\BlogCacheService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class BlogApiService
{
    public function __construct(
        private readonly BlogCacheService $cache,
    ) {}

    public function list(int $page = 1, int $perPage = 10, ?string $categorySlug = null): array
    {
        $hero = $this->cache->rememberBlogHero();

        if ($categorySlug) {
            $category = BlogCategory::where('slug', $categorySlug)->first();

            if (! $category) {
                return [
                    'hero' => $hero,
                    'featured_posts' => collect(),
                    'posts' => collect(),
                    'meta' => null,
                ];
            }

            $postIds = $category->posts()->published()->pluck('blog_post_id');

            $featuredPosts = BlogPost::published()
                ->with('categories', 'employee')
                ->whereIn('id', $postIds)
                ->where('is_featured', true)
                ->latest('published_at')
                ->take(3)
                ->get();

            $featuredIds = $featuredPosts->pluck('id');

            $posts = BlogPost::published()
                ->with('categories', 'employee')
                ->whereIn('id', $postIds)
                ->whereNotIn('id', $featuredIds)
                ->latest('published_at')
                ->paginate($perPage);

            return [
                'hero' => $hero,
                'featured_posts' => $featuredPosts,
                'posts' => $posts,
                'meta' => $posts instanceof LengthAwarePaginator ? [
                    'current_page' => $posts->currentPage(),
                    'per_page' => $posts->perPage(),
                    'total' => $posts->total(),
                    'last_page' => $posts->lastPage(),
                ] : null,
            ];
        }

        $data = $this->cache->rememberBlogIndex($page);

        $featuredPosts = $data['featuredPosts'] ?? collect();
        $posts = $data['posts'] ?? collect();

        return [
            'hero' => $hero,
            'featured_posts' => $featuredPosts,
            'posts' => $posts,
            'meta' => $posts instanceof LengthAwarePaginator ? [
                'current_page' => $posts->currentPage(),
                'per_page' => $posts->perPage(),
                'total' => $posts->total(),
                'last_page' => $posts->lastPage(),
            ] : null,
        ];
    }

    public function findBySlug(string $slug): array
    {
        $post = BlogPost::published()
            ->with('categories', 'employee')
            ->where('slug', $slug)
            ->firstOrFail();

        $related = BlogPost::published()
            ->with('categories', 'employee')
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->limit(3)
            ->get();

        return compact('post', 'related');
    }

    public function categories(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->cache->rememberBlogCategories();
    }
}
