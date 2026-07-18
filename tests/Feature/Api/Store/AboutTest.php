<?php

namespace Tests\Feature\Api\Store;

use App\Models\CoreValue;
use App\Models\GalleryItem;
use App\Models\Setting;
use App\Models\Testimonial;
use App\Models\WhyChooseUsItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AboutTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_about_page_data_matching_figma_sections(): void
    {
        Testimonial::create([
            'name' => ['en' => 'John Doe', 'ar' => 'جون دو'],
            'title' => ['en' => 'Happy Customer', 'ar' => 'عميل سعيد'],
            'content' => ['en' => 'Great service!', 'ar' => 'خدمة رائعة!'],
            'rating' => 5,
            'is_visible' => true,
        ]);

        // Inactive testimonial must not appear
        Testimonial::create([
            'name' => ['en' => 'Hidden', 'ar' => 'مخفي'],
            'title' => ['en' => 'x', 'ar' => 'x'],
            'content' => ['en' => 'x', 'ar' => 'x'],
            'rating' => 1,
            'is_visible' => false,
        ]);

        CoreValue::create([
            'icon' => 'heroicon-o-lock-closed',
            'title' => ['en' => 'Trust', 'ar' => 'الثقة'],
            'description' => ['en' => 'We keep every promise.', 'ar' => 'كل وعد نقطعه هو التزام نفي به.'],
            'sort_order' => 0,
            'is_active' => true,
        ]);

        // Inactive core value must not appear
        CoreValue::create([
            'icon' => 'x',
            'title' => ['en' => 'Hidden', 'ar' => 'مخفي'],
            'sort_order' => 1,
            'is_active' => false,
        ]);

        WhyChooseUsItem::create([
            'icon' => 'heroicon-o-user-group',
            'title' => ['en' => 'Expert Team', 'ar' => 'فريق متخصص'],
            'description' => ['en' => 'Certified advisors.', 'ar' => 'مستشارون معتمدون.'],
            'sort_order' => 0,
            'is_active' => true,
        ]);

        GalleryItem::create([
            'type' => 'image',
            'file' => 'gallery/showroom-1.jpg',
            'caption' => ['en' => 'Showroom', 'ar' => 'المعرض'],
            'alt_text' => 'Showroom photo',
            'sort_order' => 0,
            'is_active' => true,
        ]);

        Setting::create([
            'key' => 'about_hero',
            'value' => [
                'badge' => ['en' => 'Who We Are', 'ar' => 'من نحن'],
                'title' => ['en' => 'Our Core Values', 'ar' => 'قيمتنا الجوهرية'],
                'subtitle' => ['en' => '', 'ar' => ''],
                'image' => 'heroes/about/hero.jpg',
                'cta_text' => ['en' => 'Learn More', 'ar' => 'اعرف أكثر'],
                'cta_url' => '/offers',
            ],
        ]);

        Setting::create([
            'key' => 'about_story',
            'value' => [
                'title' => ['en' => 'About Qemt Najd', 'ar' => 'عن قمة نجد'],
                'description' => ['en' => 'For years, we have redefined the car buying experience.', 'ar' => 'منذ أعوام، ونحن نعيد تعريف تجربة شراء السيارات.'],
            ],
        ]);

        Setting::create([
            'key' => 'about_why_choose_us_section',
            'value' => [
                'title' => ['en' => 'Why Choose Qemt Najd?', 'ar' => 'لماذا تختار قمة نجد؟'],
                'subtitle' => ['en' => '', 'ar' => ''],
            ],
        ]);

        $response = $this->withHeaders(['Accept-Language' => 'en'])
            ->getJson(route('store.api.about'));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'hero' => ['badge', 'title', 'subtitle', 'image', 'mobile_image', 'cta_text', 'cta_url'],
                'core_values' => ['section' => ['title', 'subtitle'], 'items' => ['*' => ['icon', 'title', 'description']]],
                'company_story' => ['title', 'description', 'mission_title', 'mission_text', 'vision_title', 'vision_text', 'image'],
                'why_choose_us' => ['section' => ['title', 'subtitle'], 'items' => ['*' => ['icon', 'title', 'description']]],
                'gallery' => ['*' => ['type', 'file', 'thumbnail', 'caption', 'alt_text']],
                'testimonials' => ['*' => ['id', 'name', 'job_title', 'avatar', 'rating', 'content']],
            ],
        ]);

        $this->assertSame('Who We Are', $response->json('data.hero.badge'));
        $this->assertSame('Our Core Values', $response->json('data.hero.title'));
        $this->assertSame('About Qemt Najd', $response->json('data.company_story.title'));

        // Only the active core value / testimonial should appear
        $this->assertCount(1, $response->json('data.core_values.items'));
        $this->assertSame('Trust', $response->json('data.core_values.items.0.title'));

        $this->assertCount(1, $response->json('data.why_choose_us.items'));
        $this->assertSame('Expert Team', $response->json('data.why_choose_us.items.0.title'));
        $this->assertSame('Why Choose Qemt Najd?', $response->json('data.why_choose_us.section.title'));

        $this->assertCount(1, $response->json('data.gallery'));
        $this->assertStringContainsString('showroom-1.jpg', $response->json('data.gallery.0.file'));

        $this->assertCount(1, $response->json('data.testimonials'));
        $this->assertSame('Happy Customer', $response->json('data.testimonials.0.job_title'));
    }
}
