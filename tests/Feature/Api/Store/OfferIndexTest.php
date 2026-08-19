<?php

namespace Tests\Feature\Api\Store;

use App\Models\Brand;
use App\Models\Car;
use App\Models\Offer;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OfferIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_offers_list_with_layout_metadata(): void
    {
        // Setup Setting for main gallery
        Setting::create([
            'key' => 'main_gallery',
            'value' => ['gallery/img1.jpg', 'gallery/img2.jpg'],
        ]);

        Setting::create([
            'key' => 'store_offers_hero',
            'value' => [
                'title' => 'Offers title',
                'subtitle' => 'Offers subtitle',
                'image' => 'offers/hero.jpg',
            ],
        ]);

        $brand = Brand::create([
            'name' => ['en' => 'Toyota', 'ar' => 'تويوتا'],
            'slug' => 'toyota',
            'is_active' => true,
        ]);

        $car = Car::create([
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
            'is_featured' => true,
        ]);

        $offer = Offer::create([
            'title' => ['en' => 'Summer Sale', 'ar' => 'خصم الصيف'],
            'discount_percent' => 10,
            'special_price' => 112500,
            'is_active' => true,
            'starts_at' => now()->subDay(),
            'ends_at' => now()->addDay(),
        ]);
        $offer->cars()->attach($car->id);

        // Make API request
        $response = $this->withHeaders(['Accept-Language' => 'en'])
            ->getJson(route('store.api.offers.index'));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data',
            'meta' => [
                'current_page',
                'per_page',
                'total',
                'hero' => [
                    'title',
                    'subtitle',
                    'image',
                ],
                'hero_offer',
            ],
        ]);

        $meta = $response->json('meta');
        $this->assertEquals('Offers title', $meta['hero']['title']);
        $this->assertCount(1, $response->json('data'));
        $this->assertEquals('Summer Sale', $response->json('data.0.title'));
    }
}
