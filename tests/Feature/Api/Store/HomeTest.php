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

    public function test_it_returns_homepage_data_and_meta_structure(): void
    {
        $brand = Brand::create([
            'name' => ['en' => 'Toyota', 'ar' => 'تويوتا'],
            'slug' => 'toyota',
            'is_active' => true,
        ]);

        $car = $this->createCar($brand, featured: true);

        $offer = Offer::create([
            'car_id' => $car->id,
            'title' => ['en' => 'Summer Sale', 'ar' => 'خصم الصيف'],
            'discount_percent' => 10,
            'special_price' => 112500,
            'is_active' => true,
            'starts_at' => now()->subDay(),
            'ends_at' => now()->addDay(),
        ]);

        Setting::create([
            'key' => 'homepage_featured',
            'value' => [
                'title' => ['en' => 'Featured', 'ar' => 'مميز'],
                'description' => ['en' => 'Our top pick', 'ar' => 'أفضل اختيارنا'],
                'car_id' => $car->id,
                'offer_id' => $offer->id,
            ],
        ]);

        $response = $this->withHeaders(['Accept-Language' => 'en'])
            ->getJson(route('store.api.home'));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'hero',
                'featured_cars',
                'active_offers',
                'brands',
                'latest_posts',
                'stats',
                'testimonials',
                'partners',
                'filter_brands',
                'filter_categories',
                'filter_types',
                'filter_brand_types',
                'bento_cars',
                'highlighted_cars',
                'hero_slides',
                'featured_section' => ['title', 'description', 'car', 'offer'],
                'homepage_stats',
                'page_sections' => ['filter', 'featured_cars', 'offers', 'highlighted_cars', 'finance', 'brands', 'budget'],
            ],
        ]);

        $this->assertSame('camry', $response->json('data.featured_section.car.slug'));
        $this->assertSame($car->id, $response->json('data.featured_section.offer.car.id'));

        // Regression: featured_cars/bento_cars must reflect offers created the modern way (via car_id),
        // not only offers linked through the legacy car_offer pivot the current CRM no longer writes to.
        $featuredCar = collect($response->json('data.featured_cars'))->firstWhere('slug', 'camry');
        $this->assertNotNull($featuredCar);
        $this->assertSame(112500, $featuredCar['current_price']);
        $this->assertSame(12500, $featuredCar['savings']);

        $bentoCar = collect($response->json('data.bento_cars'))->firstWhere('slug', 'camry');
        $this->assertNotNull($bentoCar);
        $this->assertSame(112500, $bentoCar['current_price']);
    }

    public function test_featured_offer_car_is_present_when_special_installment_is_set(): void
    {
        $brand = Brand::create([
            'name' => ['en' => 'Toyota', 'ar' => 'تويوتا'],
            'slug' => 'toyota',
            'is_active' => true,
        ]);

        $car = $this->createCar($brand);

        $offer = Offer::create([
            'car_id' => $car->id,
            'title' => ['en' => 'Summer Sale', 'ar' => 'خصم الصيف'],
            'special_installment' => 999,
            'is_active' => true,
            'starts_at' => now()->subDay(),
            'ends_at' => now()->addDay(),
        ]);

        Setting::create([
            'key' => 'homepage_featured',
            'value' => ['offer_id' => $offer->id],
        ]);

        $response = $this->withHeaders(['Accept-Language' => 'en'])
            ->getJson(route('store.api.home'));

        $response->assertStatus(200);
        $this->assertSame($car->id, $response->json('data.featured_section.offer.car.id'));
        $this->assertSame(999, $response->json('data.featured_section.offer.installment_starts_from'));
    }
}
