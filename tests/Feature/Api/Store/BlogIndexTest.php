<?php

namespace Tests\Feature\Api\Store;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_blog_posts_with_layout_metadata(): void
    {
        // Setup Setting for blog hero
        Setting::create([
            'key' => 'store_blog_hero',
            'value' => [
                'title' => 'Blog title',
                'subtitle' => 'Blog subtitle',
                'image' => 'blog/hero.jpg',
            ],
        ]);

        $category = BlogCategory::create([
            'name' => ['en' => 'News', 'ar' => 'أخبار'],
            'slug' => 'news',
            'is_active' => true,
        ]);

        // Featured post
        $featuredPost = BlogPost::create([
            'title' => ['en' => 'Featured Post', 'ar' => 'مقال مميز'],
            'slug' => 'featured-post',
            'content' => ['en' => 'Content here', 'ar' => 'المحتوى هنا'],
            'is_published' => true,
            'is_featured' => true,
            'published_at' => now()->subDay(),
        ]);
        $featuredPost->categories()->attach($category->id);

        // Regular post
        $post = BlogPost::create([
            'title' => ['en' => 'Regular Post', 'ar' => 'مقال عادي'],
            'slug' => 'regular-post',
            'content' => ['en' => 'Content here', 'ar' => 'المحتوى هنا'],
            'is_published' => true,
            'is_featured' => false,
            'published_at' => now()->subDays(2),
        ]);
        $post->categories()->attach($category->id);

        // Make API request
        $response = $this->withHeaders(['Accept-Language' => 'en'])
            ->getJson(route('store.api.blog.index'));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                '*' => [
                    'id',
                    'title',
                    'slug',
                    // other post fields...
                ],
            ],
            'meta' => [
                'current_page',
                'per_page',
                'total',
                'hero' => [
                    'title',
                    'subtitle',
                    'image',
                ],
                'featured_posts' => [
                    '*' => [
                        'id',
                        'title',
                        'slug',
                    ],
                ],
                'categories' => [
                    '*' => [
                        'id',
                        'name',
                        'slug',
                    ],
                ],
            ],
        ]);

        $meta = $response->json('meta');
        $this->assertEquals('Blog title', $meta['hero']['title'] ?? null);
        $this->assertCount(1, $meta['featured_posts']);
        $this->assertEquals('featured-post', $meta['featured_posts'][0]['slug']);
        $this->assertCount(1, $meta['categories']);
        $this->assertEquals('news', $meta['categories'][0]['slug']);

        $data = $response->json('data');
        $this->assertCount(1, $data);
        $this->assertEquals('regular-post', $data[0]['slug']);
    }
}
