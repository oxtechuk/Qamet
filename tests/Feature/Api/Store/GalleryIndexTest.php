<?php

namespace Tests\Feature\Api\Store;

use App\Models\GalleryItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GalleryIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_active_gallery_items_only(): void
    {
        GalleryItem::create([
            'type' => 'image',
            'file' => 'gallery/photo.jpg',
            'caption' => ['en' => 'Photo', 'ar' => 'صورة'],
            'sort_order' => 0,
            'is_active' => true,
        ]);

        GalleryItem::create([
            'type' => 'video',
            'file' => 'gallery/videos/clip.mp4',
            'thumbnail' => 'gallery/thumbnails/clip.jpg',
            'caption' => ['en' => 'Clip', 'ar' => 'مقطع'],
            'sort_order' => 1,
            'is_active' => false,
        ]);

        $response = $this->getJson(route('store.api.gallery'));

        $response->assertStatus(200);
        $data = $response->json('data');
        $this->assertCount(1, $data);
        $this->assertSame('image', $data[0]['type']);
        $this->assertStringContainsString('photo.jpg', $data[0]['file']);
    }
}
