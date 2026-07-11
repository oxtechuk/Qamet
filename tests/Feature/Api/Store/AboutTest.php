<?php

namespace Tests\Feature\Api\Store;

use App\Models\Partner;
use App\Models\Setting;
use App\Models\Testimonial;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AboutTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_about_page_data_and_meta_structure(): void
    {
        Testimonial::create([
            'name' => ['en' => 'John Doe', 'ar' => 'جون دو'],
            'title' => ['en' => 'Happy Customer', 'ar' => 'عميل سعيد'],
            'content' => ['en' => 'Great service!', 'ar' => 'خدمة رائعة!'],
            'rating' => 5,
            'is_visible' => true,
        ]);

        Partner::create([
            'name' => 'Partner Inc',
            'logo' => 'partners/logo.png',
            'link' => 'https://partner.inc',
            'sort_order' => 1,
        ]);

        Setting::create([
            'key' => 'store_about_stats',
            'value' => [
                ['label' => 'Customers', 'value' => '1000+'],
            ],
        ]);

        $response = $this->withHeaders(['Accept-Language' => 'en'])
            ->getJson(route('store.api.about'));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'testimonials',
                'partners',
                'about_branches',
                'main_gallery',
            ],
            'meta' => [
                'page_sections' => [
                    'hero',
                    'story',
                    'partners',
                    'dealer',
                    'locations',
                    'testimonials',
                ],
                'about_stats',
            ],
        ]);

        $this->assertCount(1, $response->json('data.testimonials'));
        $this->assertCount(1, $response->json('data.partners'));
    }
}
