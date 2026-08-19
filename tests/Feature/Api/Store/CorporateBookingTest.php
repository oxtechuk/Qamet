<?php

namespace Tests\Feature\Api\Store;

use App\Models\Booking;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CorporateBookingTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_submit_corporate_financing_request(): void
    {
        $this->withoutExceptionHandling();
        $response = $this->postJson(route('store.api.booking.store'), [
            'booking_type' => 'corporate',
            'payment_method' => 'bank',
            'company_name' => 'شركة قمة الرياض للتجارة',
            'client_name' => 'سعد المنصور',
            'client_email' => 'saad@alriyadh.sa',
            'client_phone' => '0555123456',
            'car_type' => '10 سيارات تويوتا هايلوكس دبل',
            'car_count' => 10,
            'preferred_contact_date' => '2026-08-25',
            'preferred_contact_time' => 'صباحاً (9:00 ص - 12:00 م)',
            'notes' => 'نحتاج عرض سعر رسمي وشروط التأجير التمويلي للشركات',
        ]);

        $response->assertStatus(201);
        $response->assertJson([
            'success' => true,
            'data' => [
                'client_name' => 'سعد المنصور',
                'client_phone' => '0555123456',
                'booking_type' => 'corporate',
            ],
        ]);

        $this->assertDatabaseHas('bookings', [
            'booking_type' => 'corporate',
            'company_name' => 'شركة قمة الرياض للتجارة',
            'client_name' => 'سعد المنصور',
            'client_email' => 'saad@alriyadh.sa',
            'client_phone' => '0555123456',
            'car_type' => '10 سيارات تويوتا هايلوكس دبل',
            'car_count' => 10,
            'payment_method' => 'bank',
            'preferred_contact_date' => '2026-08-25',
            'preferred_contact_time' => 'صباحاً (9:00 ص - 12:00 م)',
            'notes' => 'نحتاج عرض سعر رسمي وشروط التأجير التمويلي للشركات',
        ]);

        $this->assertEquals(1, Booking::corporate()->count());
    }

    public function test_can_submit_corporate_cash_request(): void
    {
        $response = $this->postJson(route('store.api.booking.store'), [
            'booking_type' => 'corporate',
            'payment_method' => 'cash',
            'company_name' => 'مؤسسة البناء الحديث',
            'client_name' => 'فهد العتيبي',
            'client_phone' => '0544987654',
            'car_type' => '3 سيارات إيسوزو ديماكس',
            'car_count' => 3,
            'preferred_contact_time' => 'ظهراً (12:00 م - 4:00 م)',
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('bookings', [
            'booking_type' => 'corporate',
            'company_name' => 'مؤسسة البناء الحديث',
            'payment_method' => 'cash',
            'car_count' => 3,
        ]);
    }
}
