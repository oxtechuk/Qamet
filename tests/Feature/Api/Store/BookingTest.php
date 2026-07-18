<?php

namespace Tests\Feature\Api\Store;

use App\Models\Brand;
use App\Models\Car;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    private function createCar(): Car
    {
        $brand = Brand::create([
            'name' => ['en' => 'Toyota', 'ar' => 'تويوتا'],
            'slug' => 'toyota',
            'is_active' => true,
        ]);

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
        ]);
    }

    public function test_it_returns_booking_page_metadata(): void
    {
        Setting::create([
            'key' => 'store_booking_hero',
            'value' => [
                'title' => 'Book Your Car',
                'subtitle' => 'Easy financing',
                'image' => 'booking/hero.jpg',
            ],
        ]);

        $response = $this->getJson(route('store.api.booking.meta'));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'hero' => ['title', 'subtitle', 'image'],
                'steps',
                'sections',
            ],
            'meta',
        ]);

        $this->assertEquals('Book Your Car', $response->json('data.hero.title'));
    }

    public function test_it_creates_a_booking_successfully(): void
    {
        $car = $this->createCar();

        $payload = [
            'car_id' => $car->id,
            'client_name' => 'Ahmed Ali',
            'client_phone' => '0501234567',
            'client_email' => 'ahmed@example.com',
            'down_payment' => 25000,
            'duration_years' => 5,
            'booking_type' => 'purchase',
        ];

        $response = $this->postJson(route('store.api.booking.store'), $payload);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'booking_id',
                'client_name',
                'client_phone',
                'car_id',
                'booking_type',
                'monthly_installment',
                'total_price',
                'down_payment',
                'duration_years',
                'status',
            ],
            'meta',
        ]);

        $this->assertEquals('Ahmed Ali', $response->json('data.client_name'));
        $this->assertEquals('purchase', $response->json('data.booking_type'));
        $this->assertEquals('new', $response->json('data.status'));
    }

    public function test_booking_requires_client_details_and_car_identifier(): void
    {
        $response = $this->postJson(route('store.api.booking.store'), []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['car_id', 'car_type', 'client_name', 'client_phone']);
    }
}
