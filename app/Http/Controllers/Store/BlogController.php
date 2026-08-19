<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Services\Cache\BlogCacheService;

class BlogController extends Controller
{
    public function __construct(
        private readonly BlogCacheService $cache,
    ) {}

    public function index()
    {
        $page = request('page', 1);
        $data = $this->cache->rememberBlogIndex((int) $page);

        $hero = $this->cache->rememberBlogHero();

        return view('store.blog.index', array_merge($data, compact('hero')));
    }

    public function show($slug)
    {
        $post = BlogPost::published()
            ->where('slug', $slug)
            ->firstOrFail();

        $related = BlogPost::published()
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->limit(3)
            ->get();

        return view('store.blog.show', compact('post', 'related'));
    }
}
