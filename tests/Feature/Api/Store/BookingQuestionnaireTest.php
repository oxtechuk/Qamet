<?php

namespace Tests\Feature\Api\Store;

use App\Models\Brand;
use App\Models\Car;
use App\Models\Employee;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingQuestionnaireTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_submit_cash_order_with_urgency_and_auto_assign_to_cash_rep(): void
    {
        Setting::create(['key' => 'auto_assign_bookings', 'value' => '1']);

        $cashRep = Employee::create([
            'name' => 'مندوب كاش',
            'email' => 'cash@test.com',
            'password' => 'secret',
            'role' => 'sales',
            'sales_type' => 'cash',
            'is_active' => true,
        ]);

        $financeRep = Employee::create([
            'name' => 'مندوب تقسيط',
            'email' => 'finance@test.com',
            'password' => 'secret',
            'role' => 'sales',
            'sales_type' => 'finance',
            'is_active' => true,
        ]);

        $brand = Brand::create(['name' => 'تويوتا', 'slug' => 'toyota']);
        $car = Car::create([
            'brand_id' => $brand->id,
            'name' => 'تويوتا كامري 2025',
            'model' => 'Camry',
            'year' => 2025,
            'min_down_payment' => 5000,
            'min_installment' => 1200,
            'slug' => 'toyota-camry-2025',
            'cash_price' => 120000,
            'is_active' => true,
        ]);

        $response = $this->postJson(route('store.api.booking.store'), [
            'car_id' => $car->id,
            'payment_method' => 'cash',
            'client_name' => 'محمد أحمد',
            'client_phone' => '0512345678',
            'car_type' => 'تويوتا كامري 2025 GLX',
            'purchase_urgency' => 'today',
            'notes' => 'طلب كاش عاجل',
        ]);

        $response->assertStatus(201);
        $response->assertJson([
            'success' => true,
            'data' => [
                'client_name' => 'محمد أحمد',
                'client_phone' => '0512345678',
                'payment_method' => 'cash',
            ],
        ]);

        $this->assertDatabaseHas('bookings', [
            'client_name' => 'محمد أحمد',
            'payment_method' => 'cash',
            'purchase_urgency' => 'today',
            'assigned_to' => $cashRep->id,
        ]);
    }

    public function test_can_submit_finance_order_with_questionnaire_and_auto_assign_to_finance_rep(): void
    {
        Setting::create(['key' => 'auto_assign_bookings', 'value' => '1']);

        $cashRep = Employee::create([
            'name' => 'مندوب كاش',
            'email' => 'cash@test.com',
            'password' => 'secret',
            'role' => 'sales',
            'sales_type' => 'cash',
            'is_active' => true,
        ]);

        $financeRep = Employee::create([
            'name' => 'مندوب تقسيط',
            'email' => 'finance@test.com',
            'password' => 'secret',
            'role' => 'sales',
            'sales_type' => 'finance',
            'is_active' => true,
        ]);

        $brand = Brand::create(['name' => 'هيونداي', 'slug' => 'hyundai']);
        $car = Car::create([
            'brand_id' => $brand->id,
            'name' => 'سوناتا 2025',
            'model' => 'Sonata',
            'year' => 2025,
            'min_down_payment' => 5000,
            'min_installment' => 1100,
            'slug' => 'sonata-2025',
            'cash_price' => 110000,
            'is_active' => true,
        ]);

        $response = $this->postJson(route('store.api.booking.store'), [
            'car_id' => $car->id,
            'payment_method' => 'bank',
            'client_name' => 'عبدالله خالد',
            'client_phone' => '0598765432',
            'car_type' => 'سوناتا نص فل',
            'age' => 34,
            'work_sector' => 'government',
            'salary' => 14000,
            'service_duration' => '5 سنوات',
            'has_downpayment' => true,
            'down_payment' => 20000,
            'has_obligations' => true,
            'monthly_obligations' => 1500,
            'purchase_urgency' => '3_days',
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('bookings', [
            'client_name' => 'عبدالله خالد',
            'payment_method' => 'bank',
            'age' => 34,
            'work_sector' => 'government',
            'salary' => 14000,
            'service_duration' => '5 سنوات',
            'has_downpayment' => 1,
            'down_payment' => 20000,
            'has_obligations' => 1,
            'monthly_obligations' => 1500,
            'purchase_urgency' => '3_days',
            'assigned_to' => $financeRep->id,
        ]);
    }
}
