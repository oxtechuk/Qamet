<?php

namespace Tests\Feature\Api\Store;

use App\Models\Brand;
use App\Models\Car;
use App\Models\CarCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CarColorImagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_car_can_store_and_return_exterior_and_interior_colors_with_multiple_images(): void
    {
        $brand = Brand::create([
            'name' => ['ar' => 'تويوتا', 'en' => 'Toyota'],
            'slug' => 'toyota',
        ]);

        $category = CarCategory::create([
            'name' => ['ar' => 'سيدان', 'en' => 'Sedan'],
            'slug' => 'sedan',
        ]);

        $car = Car::create([
            'brand_id' => $brand->id,
            'category_id' => $category->id,
            'name' => ['ar' => 'تويوتا كامري 2026', 'en' => 'Toyota Camry 2026'],
            'model' => 'Camry',
            'slug' => ['ar' => 'toyota-camry-2026-ar', 'en' => 'toyota-camry-2026'],
            'cash_price' => 125000,
            'min_down_payment' => 0,
            'min_installment' => 1500,
            'type' => 'sedan',
            'year' => 2026,
            'is_active' => true,
            'exterior_colors' => [
                [
                    'name' => 'أبيض لؤلؤي',
                    'hex' => '#FFFFFF',
                    'images' => [
                        'cars/exterior-colors/white_front.webp',
                        'cars/exterior-colors/white_side.webp',
                        'cars/exterior-colors/white_back.webp',
                    ],
                ],
                [
                    'name' => 'أسود ملكي',
                    'hex' => '#000000',
                    'images' => [
                        'cars/exterior-colors/black_front.webp',
                        'cars/exterior-colors/black_side.webp',
                    ],
                ],
            ],
            'interior_colors' => [
                [
                    'name' => 'جلد جملي فاخر',
                    'hex' => '#C19A6B',
                    'images' => [
                        'cars/interior-colors/camel_seats.webp',
                        'cars/interior-colors/camel_dashboard.webp',
                    ],
                ],
                [
                    'name' => 'أسود مطرز',
                    'hex' => '#1A1A1A',
                    'images' => [
                        'cars/interior-colors/black_cabin.webp',
                    ],
                ],
            ],
        ]);

        $this->assertCount(2, $car->formatted_exterior_colors);
        $this->assertCount(3, $car->formatted_exterior_colors[0]['images']);
        $this->assertCount(2, $car->formatted_interior_colors);
        $this->assertCount(2, $car->formatted_interior_colors[0]['images']);

        $response = $this->getJson(route('store.api.cars.show', 'toyota-camry-2026'));

        $response->assertStatus(200);
        $response->assertJsonPath('data.name', 'تويوتا كامري 2026');
        $response->assertJsonCount(2, 'data.exterior_colors');
        $response->assertJsonCount(3, 'data.exterior_colors.0.images');
        $response->assertJsonCount(2, 'data.interior_colors');
        $response->assertJsonCount(2, 'data.interior_colors.0.images');
    }
}
