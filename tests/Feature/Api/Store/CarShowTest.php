<?php

namespace Tests\Feature\Api\Store;

use App\Models\Brand;
use App\Models\Car;
use App\Models\CarCategory;
use App\Models\Feature;
use App\Models\Offer;
use App\Models\Specification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CarShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_detailed_car_data_matching_figma_requirements(): void
    {
        // 1. Create dependencies
        $brand = Brand::create([
            'name' => ['en' => 'Toyota', 'ar' => 'تويوتا'],
            'slug' => 'toyota',
            'is_active' => true,
        ]);

        $category = CarCategory::create([
            'name' => ['en' => 'Sedan', 'ar' => 'سيدان'],
            'slug' => 'sedan',
            'is_active' => true,
        ]);

        // 2. Create the target car
        $car = Car::create([
            'brand_id' => $brand->id,
            'category_id' => $category->id,
            'name' => ['en' => 'Toyota Camry', 'ar' => 'تويوتا كامري'],
            'slug' => ['en' => 'toyota-camry-2025', 'ar' => 'تويوتا-كامري-2025'],
            'model' => 'Camry',
            'year' => 2025,
            'type' => 'sedan',
            'cash_price' => 125000,
            'min_down_payment' => 25000,
            'min_installment' => 3500,
            'colors' => [
                ['name' => 'White', 'hex' => '#FFFFFF', 'image' => null],
            ],
            'specs' => [
                'gearbox' => 'Automatic',
                'seats' => 5,
                'hp' => '203 HP',
            ],
            'description' => ['en' => 'Excellent car.', 'ar' => 'سيارة ممتازة.'],
            'is_featured' => true,
            'is_active' => true,
            'availability_status' => 'available',
        ]);

        // Add images with different types
        $car->images()->createMany([
            ['image_path' => 'cars/camry-ext1.jpg', 'type' => 'exterior', 'alt' => 'Camry Exterior 1', 'sort_order' => 1],
            ['image_path' => 'cars/camry-int1.jpg', 'type' => 'interior', 'alt' => 'Camry Interior 1', 'sort_order' => 2],
            ['image_path' => 'cars/camry-gen1.jpg', 'type' => 'general', 'alt' => 'Camry General 1', 'sort_order' => 3],
        ]);

        // Add specifications
        $spec = Specification::create([
            'name' => ['en' => 'Engine', 'ar' => 'المحرك'],
            'icon' => 'bi-gear',
        ]);
        $car->specifications()->attach($spec->id);

        // Add features
        $feature = Feature::create([
            'name' => ['en' => 'Sunroof', 'ar' => 'فتحة سقف'],
            'icon' => 'bi-sun',
        ]);
        $car->features_list()->attach($feature->id);

        // Add offer (created the modern way, via car_id, matching how the CRM creates offers today)
        $offer = Offer::create([
            'car_id' => $car->id,
            'title' => ['en' => 'Summer Sale', 'ar' => 'خصم الصيف'],
            'discount_percent' => 10,
            'special_price' => 112500,
            'is_active' => true,
            'starts_at' => now()->subDay(),
            'ends_at' => now()->addDay(),
        ]);

        // 3. Make request
        $response = $this->getJson(
            route('store.api.cars.show', ['slug' => 'toyota-camry-2025']),
            ['Accept-Language' => 'en']
        );

        // 4. Assertions
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'id',
                'name',
                'slug',
                'exterior_images',
                'interior_images',
                'images',
                'cash_price',
                'current_price',
                'savings',
                'min_installment',
                'min_down_payment',
                'year',
                'type',
                'colors',
                'specs',
                'brand',
                'category',
                'active_offer',
                'active_offers',
                'specifications' => [
                    '*' => [
                        'id',
                        'name',
                        'icon',
                    ],
                ],
                'features_list' => [
                    '*' => [
                        'id',
                        'name',
                        'icon',
                    ],
                ],
            ],
        ]);

        // Verify values
        $data = $response->json('data');
        $this->assertEquals('toyota-camry-2025', $data['slug']);
        $this->assertCount(1, $data['exterior_images']);
        $this->assertCount(1, $data['interior_images']);
        $this->assertEquals(112500, $data['current_price']);
        $this->assertEquals(12500, $data['savings']);
        $this->assertNotNull($data['active_offer']);
        $this->assertEquals($offer->id, $data['active_offer']['id']);

        // Verify spec details
        $this->assertEquals('Engine', $data['specifications'][0]['name']);
        $this->assertEquals('bi-gear', $data['specifications'][0]['icon']);

        // Verify feature details
        $this->assertEquals('Sunroof', $data['features_list'][0]['name']);
        $this->assertEquals('bi-sun', $data['features_list'][0]['icon']);
    }
}
