<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\BookingNote;
use App\Models\Employee;
use Database\Seeders\PermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingSalesNotesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(PermissionSeeder::class);
    }

    public function test_sales_employee_can_add_booking_note_without_altering_client_notes(): void
    {
        $employee = Employee::create([
            'name' => 'Sales Rep 1',
            'username' => 'salesrep1',
            'email' => 'sales1@test.com',
            'password' => bcrypt('password'),
            'is_active' => true,
        ]);
        $employee->assignRole('employee');

        $initialClientNote = 'ملاحظة العميل الأصلية: أرغب في لون أبيض';
        $booking = Booking::create([
            'client_name' => 'محمد أحمد',
            'client_phone' => '0501234567',
            'down_payment' => 10000,
            'duration_years' => 5,
            'interest_rate' => 4.5,
            'monthly_installment' => 1200,
            'total_price' => 82000,
            'status' => 'new',
            'notes' => $initialClientNote,
            'assigned_to' => $employee->id,
        ]);

        $this->actingAs($employee, 'employee');

        // Add sales note
        $salesNote = BookingNote::create([
            'booking_id' => $booking->id,
            'employee_id' => $employee->id,
            'type' => 'call',
            'note' => 'تم الاتصال بالعميل وأبدى اهتماماً كبيراً بالعرض',
        ]);

        $this->assertDatabaseHas('booking_notes', [
            'id' => $salesNote->id,
            'booking_id' => $booking->id,
            'employee_id' => $employee->id,
            'type' => 'call',
            'note' => 'تم الاتصال بالعميل وأبدى اهتماماً كبيراً بالعرض',
        ]);

        // Verify client note has not been modified or polluted
        $booking->refresh();
        $this->assertSame($initialClientNote, $booking->notes);
        $this->assertCount(1, $booking->notes_list);
    }

    public function test_booking_view_page_renders_for_sales_employee(): void
    {
        app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        $employee = Employee::create([
            'name' => 'Sales Rep 2',
            'username' => 'salesrep2',
            'email' => 'sales2@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);
        $employee->assignRole('admin');

        $booking = Booking::create([
            'client_name' => 'عبدالله خالد',
            'client_phone' => '0559876543',
            'down_payment' => 5000,
            'duration_years' => 3,
            'interest_rate' => 3.5,
            'monthly_installment' => 1500,
            'total_price' => 59000,
            'status' => 'contacted',
            'notes' => 'يرغب في استلام السيارة من فرع جدة',
            'assigned_to' => $employee->id,
        ]);

        $this->actingAs($employee, 'employee');

        $response = $this->get("/admin/bookings/{$booking->id}");
        $response->assertSuccessful();
        $this->assertStringContainsString('notes', $response->getContent());
    }
}
