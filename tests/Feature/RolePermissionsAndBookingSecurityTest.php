<?php

namespace Tests\Feature;

use App\Filament\Resources\BookingResource;
use App\Filament\Resources\RoleResource;
use App\Models\Booking;
use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RolePermissionsAndBookingSecurityTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(\Database\Seeders\PermissionSeeder::class);
    }

    public function test_role_resource_has_arabic_labels_and_categorized_permissions(): void
    {
        $this->assertEquals('الدور والصلاحية', RoleResource::getModelLabel());
        $this->assertEquals('الأدوار والصلاحيات', RoleResource::getPluralModelLabel());

        $groups = RoleResource::getPermissionsGrouped();
        $this->assertArrayHasKey('الطلبات والحجوزات ومبيعات الكاش والتقسيط', $groups);
        $this->assertArrayHasKey('العملاء والليدز', $groups);
        $this->assertArrayHasKey('السيارات والكتالوج', $groups);
        $this->assertArrayHasKey('الفريق والمستخدمين', $groups);
        $this->assertArrayHasKey('الإعدادات والربط والتقنية', $groups);

        $options = RoleResource::getPermissionOptions();
        $this->assertArrayHasKey('manage-bookings', $options);
        $this->assertArrayHasKey('manage-cash-bookings', $options);
        $this->assertArrayHasKey('manage-finance-bookings', $options);
        $this->assertArrayHasKey('manage-corporate-bookings', $options);

        $this->assertEquals('إدارة وعرض كافة الطلبات (شامل كاش وتقسيط)', $options['manage-bookings']);
        $this->assertEquals('إدارة وعرض طلبات الكاش فقط 💵', $options['manage-cash-bookings']);
        $this->assertEquals('إدارة وعرض طلبات التقسيط والتمويل فقط 💳', $options['manage-finance-bookings']);
        $this->assertEquals('إدارة وعرض طلبات تمويل الشركات 🏢', $options['manage-corporate-bookings']);

        $descriptions = RoleResource::getPermissionDescriptions();
        $this->assertArrayHasKey('manage-cash-bookings', $descriptions);
        $this->assertArrayHasKey('manage-finance-bookings', $descriptions);
    }

    public function test_role_permission_grants_cash_or_finance_scoping(): void
    {
        $cashRole = Role::firstOrCreate(['name' => 'cash-officer', 'guard_name' => 'employee']);
        $cashRole->givePermissionTo('manage-cash-bookings');

        $emp = Employee::create([
            'name' => 'Cash Officer',
            'email' => 'officer@qmtnjd.test',
            'password' => 'password123',
            'role' => 'employee',
            'sales_type' => 'cash',
            'is_active' => true,
        ]);
        $emp->assignRole($cashRole);

        $cashBooking = $this->createBooking([
            'client_name' => 'Cash Only Client',
            'payment_method' => 'cash',
            'assigned_to' => null,
        ]);

        $financeBooking = $this->createBooking([
            'client_name' => 'Finance Only Client',
            'payment_method' => 'finance',
            'assigned_to' => null,
        ]);

        Auth::guard('employee')->setUser($emp);

        $visibleIds = BookingResource::getEloquentQuery()->pluck('id')->toArray();
        $this->assertContains($cashBooking->id, $visibleIds);
        $this->assertNotContains($financeBooking->id, $visibleIds);
    }

    private function createBooking(array $attributes = []): Booking
    {
        return Booking::create(array_merge([
            'client_name' => 'Test Client',
            'client_phone' => '0500000000',
            'payment_method' => 'cash',
            'down_payment' => 0,
            'duration_years' => 1,
            'interest_rate' => 0,
            'monthly_installment' => 0,
            'total_price' => 100000,
            'status' => 'new',
        ], $attributes));
    }

    public function test_admin_can_delete_and_see_all_bookings(): void
    {
        $admin = Employee::create([
            'name' => 'Super Admin',
            'email' => 'admin@qmtnjd.test',
            'password' => 'password123',
            'role' => 'admin',
            'sales_type' => 'all',
            'is_active' => true,
        ]);
        $admin->assignRole('admin');

        $cashBooking = $this->createBooking([
            'client_name' => 'Cash Client',
            'payment_method' => 'cash',
        ]);

        $financeBooking = $this->createBooking([
            'client_name' => 'Finance Client',
            'payment_method' => 'bank',
        ]);

        Auth::guard('employee')->setUser($admin);

        // Security check: Admin can delete
        $this->assertTrue(BookingResource::canDelete($cashBooking));
        $this->assertTrue(BookingResource::canDeleteAny());

        // Query check: Admin sees both
        $visibleIds = BookingResource::getEloquentQuery()->pluck('id')->toArray();
        $this->assertContains($cashBooking->id, $visibleIds);
        $this->assertContains($financeBooking->id, $visibleIds);
    }

    public function test_cash_sales_rep_only_sees_cash_bookings_and_cannot_delete(): void
    {
        $cashRep = Employee::create([
            'name' => 'Cash Rep',
            'email' => 'cash@qmtnjd.test',
            'password' => 'password123',
            'role' => 'employee',
            'sales_type' => 'cash',
            'is_active' => true,
        ]);
        $cashRep->assignRole('employee');

        $unassignedCash = $this->createBooking([
            'client_name' => 'Unassigned Cash',
            'payment_method' => 'cash',
            'assigned_to' => null,
        ]);

        $unassignedFinance = $this->createBooking([
            'client_name' => 'Unassigned Finance',
            'payment_method' => 'bank',
            'assigned_to' => null,
        ]);

        $otherRep = Employee::create([
            'name' => 'Other Rep',
            'email' => 'other@qmtnjd.test',
            'password' => 'password123',
            'role' => 'employee',
            'sales_type' => 'cash',
            'is_active' => true,
        ]);

        $assignedToOther = $this->createBooking([
            'client_name' => 'Other Cash',
            'payment_method' => 'cash',
            'assigned_to' => $otherRep->id,
        ]);

        $assignedToMe = $this->createBooking([
            'client_name' => 'My Assigned Finance',
            'payment_method' => 'installment',
            'assigned_to' => $cashRep->id,
        ]);

        Auth::guard('employee')->setUser($cashRep);

        // Security check: Employee CANNOT delete
        $this->assertFalse(BookingResource::canDelete($unassignedCash));
        $this->assertFalse(BookingResource::canDeleteAny());

        // Scoping check
        $visibleIds = BookingResource::getEloquentQuery()->pluck('id')->toArray();
        $this->assertContains($unassignedCash->id, $visibleIds);
        $this->assertContains($assignedToMe->id, $visibleIds);
        $this->assertNotContains($unassignedFinance->id, $visibleIds);
        $this->assertNotContains($assignedToOther->id, $visibleIds);
    }

    public function test_finance_sales_rep_only_sees_finance_bookings_and_cannot_delete(): void
    {
        $financeRep = Employee::create([
            'name' => 'Finance Rep',
            'email' => 'fin@qmtnjd.test',
            'password' => 'password123',
            'role' => 'employee',
            'sales_type' => 'finance',
            'is_active' => true,
        ]);
        $financeRep->assignRole('employee');

        $unassignedCash = $this->createBooking([
            'client_name' => 'Unassigned Cash',
            'payment_method' => 'cash',
            'assigned_to' => null,
        ]);

        $unassignedFinance = $this->createBooking([
            'client_name' => 'Unassigned Finance',
            'payment_method' => 'finance',
            'assigned_to' => null,
        ]);

        $unassignedCorporate = $this->createBooking([
            'client_name' => 'Unassigned Corp',
            'booking_type' => 'corporate',
            'payment_method' => null,
            'assigned_to' => null,
        ]);

        Auth::guard('employee')->setUser($financeRep);

        // Security check: Employee CANNOT delete
        $this->assertFalse(BookingResource::canDelete($unassignedFinance));
        $this->assertFalse(BookingResource::canDeleteAny());

        // Scoping check
        $visibleIds = BookingResource::getEloquentQuery()->pluck('id')->toArray();
        $this->assertNotContains($unassignedCash->id, $visibleIds);
        $this->assertContains($unassignedFinance->id, $visibleIds);
        $this->assertContains($unassignedCorporate->id, $visibleIds);
    }
}
