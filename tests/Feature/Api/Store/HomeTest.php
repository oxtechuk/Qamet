<?php

namespace Tests\Feature\Api\Store;

use App\Models\Brand;
use App\Models\Car;
use App\Models\Offer;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use RefreshDatabase;

    private function createCar(Brand $brand, bool $featured = false): Car
    {
        return Car::create([
            'brand_id' => $brand->id,
            'name' => ['en' => 'Camry', 'ar' => 'كامري'],
            'slug' => ['en' => 'camry', 'ar' => 'كامري'],
            'model' => 'Camry',
            'year' => 2025,
            'type' => 'sedan',
            'cash_price' => 125000,
            'min_down_payment' => 25000,
            'min_installment' => 3500,
            'is_active' => true,
            'is_featured' => $featured,
        ]);
    }

    public function test_it_returns_homepage_data_matching_figma_sections(): void
    {
        $brand = Brand::create([
            'name' => ['en' => 'Toyota', 'ar' => 'تويوتا'],
            'slug' => 'toyota',
            'is_active' => true,
        ]);

        $car = $this->createCar($brand, featured: true);

        Offer::create([
            'car_id' => $car->id,
            'title' => ['en' => 'Summer Sale', 'ar' => 'خصم الصيف'],
            'discount_percent' => 10,
            'special_price' => 112500,
            'is_active' => true,
            'starts_at' => now()->subDay(),
            'ends_at' => now()->addDays(3),
        ]);

        Setting::create([
            'key' => 'hero_slides',
            'value' => [
                [
                    'image' => 'slides/home/slide-1.jpg',
                    'car_id' => $car->id,
                    'title_ar' => 'كامري 2025',
                    'title_en' => 'Camry 2025',
                    'button_text_ar' => 'استعرض العروض',
                    'button_text_en' => 'Browse Offers',
                    'link' => '/offers',
                    'is_active' => true,
                ],
            ],
        ]);

        Setting::create([
            'key' => 'home_why_us',
            'value' => [
                [
                    'icon' => 'heroicon-o-currency-dollar',
                    'title_ar' => 'أسعار لا تتوقع',
                    'title_en' => 'Unbeatable Prices',
                    'description_ar' => 'وصف',
                    'description_en' => 'Description',
                ],
            ],
        ]);

        Setting::create([
            'key' => 'home_banner',
            'value' => [
                'image' => 'banners/home/banner.jpg',
                'title' => ['en' => 'Ford Territory 2026', 'ar' => 'فورد تيريتوري 2026'],
                'button_text' => ['en' => 'Discover', 'ar' => 'اكتشف'],
                'url' => '/offers/ford-territory',
                'starts_at' => now()->subDay()->toDateTimeString(),
                'ends_at' => now()->addWeek()->toDateTimeString(),
                'active' => true,
            ],
        ]);

        Setting::create([
            'key' => 'home_budget_brackets',
            'value' => [
                ['label_ar' => 'أقل من 150 ألف', 'label_en' => 'Under 150k', 'min' => 0, 'max' => 150000],
                ['label_ar' => '150 - 250 ألف', 'label_en' => '150k - 250k', 'min' => 150001, 'max' => 250000],
            ],
        ]);

        $response = $this->withHeaders(['Accept-Language' => 'en'])
            ->getJson(route('store.api.home'));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'hero_slides' => ['*' => ['image', 'title', 'car', 'button_text', 'button_link', 'button_2_text', 'button_2_link']],
                'brands',
                'latest_cars' => ['section', 'items'],
                'why_us' => ['*' => ['icon', 'title', 'description']],
                'campaign_banner' => ['image', 'mobile_image', 'title', 'button_text', 'url', 'is_active'],
                'offers' => ['section', 'items'],
                'cars_by_budget' => ['section', 'brackets' => ['*' => ['label', 'min', 'max', 'count']], 'cars'],
            ],
        ]);

        // Hero slide resolves the linked car's price
        $this->assertSame('Camry 2025', $response->json('data.hero_slides.0.title'));
        $this->assertSame($car->id, $response->json('data.hero_slides.0.car.id'));
        $this->assertSame(112500, $response->json('data.hero_slides.0.car.current_price'));

        // Why Us resolves English locale
        $this->assertSame('Unbeatable Prices', $response->json('data.why_us.0.title'));

        // Campaign banner is active (within date range and toggled on)
        $this->assertTrue($response->json('data.campaign_banner.is_active'));
        $this->assertSame('Discover', $response->json('data.campaign_banner.button_text'));

        // Budget bracket counts real cars in range (by base cash_price)
        $this->assertSame('Under 150k', $response->json('data.cars_by_budget.brackets.0.label'));
        $this->assertSame(1, $response->json('data.cars_by_budget.brackets.0.count'));
        $this->assertSame(0, $response->json('data.cars_by_budget.brackets.1.count'));

        // Latest cars grid contains the featured car
        $latestCar = collect($response->json('data.latest_cars.items'))->firstWhere('slug', 'camry');
        $this->assertNotNull($latestCar);
        $this->assertSame(112500, $latestCar['current_price']);
        $this->assertSame(12500, $latestCar['savings']);

        // Offer card exposes a locale-aware time_remaining (regression: this used to be hardcoded Arabic)
        $offerCard = $response->json('data.offers.items.0');
        $this->assertSame($car->id, $offerCard['car']['id']);
        $this->assertStringContainsString('Ends in', $offerCard['time_remaining']);
    }

    public function test_time_remaining_is_localized_for_arabic(): void
    {
        $brand = Brand::create(['name' => ['en' => 'Toyota', 'ar' => 'تويوتا'], 'slug' => 'toyota', 'is_active' => true]);
        $car = $this->createCar($brand);

        Offer::create([
            'car_id' => $car->id,
            'title' => ['en' => 'Summer Sale', 'ar' => 'خصم الصيف'],
            'special_price' => 112500,
            'is_active' => true,
            'starts_at' => now()->subDay(),
            'ends_at' => now()->addDays(3),
        ]);

        $response = $this->withHeaders(['Accept-Language' => 'ar'])
            ->getJson(route('store.api.home'));

        $response->assertStatus(200);
        $this->assertStringContainsString('ينتهي', $response->json('data.offers.items.0.time_remaining'));
    }

    public function test_inactive_hero_slide_is_excluded(): void
    {
        Setting::create([
            'key' => 'hero_slides',
            'value' => [
                ['image' => 'a.jpg', 'title_en' => 'Active', 'is_active' => true],
                ['image' => 'b.jpg', 'title_en' => 'Inactive', 'is_active' => false],
            ],
        ]);

        $response = $this->withHeaders(['Accept-Language' => 'en'])
            ->getJson(route('store.api.home'));

        $response->assertStatus(200);
        $slides = $response->json('data.hero_slides');
        $this->assertCount(1, $slides);
        $this->assertSame('Active', $slides[0]['title']);
    }

    public function test_expired_campaign_banner_is_marked_inactive(): void
    {
        Setting::create([
            'key' => 'home_banner',
            'value' => [
                'image' => 'banner.jpg',
                'title' => ['en' => 'Old Promo'],
                'starts_at' => now()->subMonth()->toDateTimeString(),
                'ends_at' => now()->subWeek()->toDateTimeString(),
                'active' => true,
            ],
        ]);

        $response = $this->withHeaders(['Accept-Language' => 'en'])
            ->getJson(route('store.api.home'));

        $response->assertStatus(200);
        $this->assertFalse($response->json('data.campaign_banner.is_active'));
    }
}
