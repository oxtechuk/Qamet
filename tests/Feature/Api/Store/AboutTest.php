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
            'key' => 'about_stats',
            'value' => [
                ['label' => 'Customers', 'value' => '1000+'],
            ],
        ]);

        Setting::create([
            'key' => 'about_core_values',
            'value' => [
                ['icon' => 'trust', 'title' => ['en' => 'Trust', 'ar' => 'الثقة'], 'description' => ['en' => 'We keep every promise.', 'ar' => 'كل وعد نقطعه هو التزام نفي به.']],
            ],
        ]);

        Setting::create([
            'key' => 'about_why_choose_us',
            'value' => [
                ['icon' => 'team', 'title' => ['en' => 'Expert Team', 'ar' => 'فريق متخصص'], 'description' => ['en' => 'Certified advisors.', 'ar' => 'مستشارون معتمدون.']],
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
                'about_stats',
                'about_core_values',
                'about_why_choose_us',
                'main_gallery',
                'page_sections' => [
                    'hero',
                    'story',
                    'values',
                    'partners',
                    'why_choose_us',
                    'dealer',
                    'locations',
                    'testimonials',
                ],
            ],
        ]);

        $this->assertCount(1, $response->json('data.testimonials'));
        $this->assertCount(1, $response->json('data.partners'));
        $this->assertSame('Trust', $response->json('data.about_core_values.0.title'));
        $this->assertSame('Expert Team', $response->json('data.about_why_choose_us.0.title'));
    }
}
