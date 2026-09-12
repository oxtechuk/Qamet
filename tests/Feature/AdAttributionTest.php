<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Car;
use App\Models\Lead;
use App\Services\Analytics\AdAttributionService;
use App\Services\Api\Store\Data\BookingData;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdAttributionTest extends TestCase
{
    use RefreshDatabase;

    public function test_platform_detection_from_source_and_click_ids(): void
    {
        // Google detection
        $this->assertEquals('google', BookingData::detectPlatform(null, 'google', null));
        $this->assertEquals('google', BookingData::detectPlatform(null, 'cpc', 'gclid_xyz123'));

        // Meta detection
        $this->assertEquals('meta', BookingData::detectPlatform(null, 'facebook', null));
        $this->assertEquals('meta', BookingData::detectPlatform(null, 'instagram', null));
        $this->assertEquals('meta', BookingData::detectPlatform(null, 'paid_social', 'fbclid_abc'));

        // Snapchat detection
        $this->assertEquals('snapchat', BookingData::detectPlatform(null, 'snapchat', null));
        $this->assertEquals('snapchat', BookingData::detectPlatform(null, 'story_ad', 'sccid_snap'));

        // TikTok detection
        $this->assertEquals('tiktok', BookingData::detectPlatform(null, 'tiktok', null));
        $this->assertEquals('tiktok', BookingData::detectPlatform(null, 'video_ad', 'ttclid_tiktok'));

        // Explicit override takes precedence
        $this->assertEquals('snapchat', BookingData::detectPlatform('snapchat', 'google', 'gclid_123'));
    }

    private function createTestCar(): Car
    {
        $brand = \App\Models\Brand::create(['name' => ['ar' => 'تويوتا', 'en' => 'Toyota']]);

        return Car::create([
            'brand_id' => $brand->id,
            'name' => ['ar' => 'كامري', 'en' => 'Camry'],
            'slug' => ['ar' => 'camry-ar', 'en' => 'camry-en'],
            'model' => 'Camry',
            'year' => 2026,
            'type' => 'sedan',
            'cash_price' => 150000,
            'min_down_payment' => 10000,
            'min_installment' => 2000,
            'is_active' => true,
        ]);
    }

    public function test_booking_api_saves_attribution_and_syncs_with_lead(): void
    {
        $car = $this->createTestCar();

        $payload = [
            'car_id' => $car->id,
            'client_name' => 'محمد أحمد',
            'client_phone' => '0555123456',
            'client_email' => 'mohammed@example.com',
            'ad_platform' => 'meta',
            'utm_source' => 'instagram',
            'utm_medium' => 'reel',
            'utm_campaign' => 'suv_promo_2026',
            'click_id' => 'fbclid_test_999',
        ];

        $response = $this->postJson('/api/store/booking', $payload);
        $response->assertSuccessful();

        // Check Booking in database
        $this->assertDatabaseHas('bookings', [
            'client_phone' => '0555123456',
            'ad_platform' => 'meta',
            'utm_source' => 'instagram',
            'utm_medium' => 'reel',
            'utm_campaign' => 'suv_promo_2026',
            'click_id' => 'fbclid_test_999',
        ]);

        // Check Lead was auto-created and synced with attribution
        $this->assertDatabaseHas('leads', [
            'client_phone' => '0555123456',
            'ad_platform' => 'meta',
            'utm_source' => 'instagram',
            'utm_campaign' => 'suv_promo_2026',
        ]);
    }

    public function test_ad_attribution_service_aggregates_kpis(): void
    {
        $car = $this->createTestCar();

        // Create 2 Google Bookings (1 sold)
        Booking::create([
            'car_id' => $car->id,
            'client_name' => 'عميل جوجل 1',
            'client_phone' => '0500000001',
            'status' => 'sold',
            'total_price' => 120000,
            'down_payment' => 20000,
            'duration_years' => 3,
            'interest_rate' => 4,
            'monthly_installment' => 3000,
            'ad_platform' => 'google',
            'utm_source' => 'google',
            'utm_campaign' => 'search_cars',
        ]);

        Booking::create([
            'car_id' => $car->id,
            'client_name' => 'عميل جوجل 2',
            'client_phone' => '0500000002',
            'status' => 'new',
            'total_price' => 100000,
            'down_payment' => 10000,
            'duration_years' => 3,
            'interest_rate' => 4,
            'monthly_installment' => 2500,
            'ad_platform' => 'google',
            'utm_source' => 'google',
            'utm_campaign' => 'search_cars',
        ]);

        // Create 1 TikTok Booking (sold)
        Booking::create([
            'car_id' => $car->id,
            'client_name' => 'عميل تيك توك',
            'client_phone' => '0500000003',
            'status' => 'sold',
            'total_price' => 90000,
            'down_payment' => 15000,
            'duration_years' => 2,
            'interest_rate' => 4,
            'monthly_installment' => 3500,
            'ad_platform' => 'tiktok',
            'utm_source' => 'tiktok',
            'utm_campaign' => 'tiktok_trends',
        ]);

        $service = new AdAttributionService;
        $kpis = $service->getOverviewKpis();

        $this->assertEquals(2, $kpis['sold_ad_bookings']);
        $this->assertEquals(210000, $kpis['total_ad_revenue']);

        $platforms = $service->getPlatformBreakdown();
        $this->assertEquals(1, $platforms['google']['sold_bookings']);
        $this->assertEquals(120000, $platforms['google']['total_revenue']);
        $this->assertEquals(1, $platforms['tiktok']['sold_bookings']);
        $this->assertEquals(90000, $platforms['tiktok']['total_revenue']);
        $this->assertEquals(0, $platforms['snapchat']['sold_bookings']);
    }
}
