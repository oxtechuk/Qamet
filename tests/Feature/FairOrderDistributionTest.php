<?php

namespace Tests\Feature;

use App\Filament\Resources\EmployeeResource;
use App\Models\Booking;
use App\Models\Employee;
use App\Models\Setting;
use App\Services\BookingAssignmentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class FairOrderDistributionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(\Database\Seeders\PermissionSeeder::class);
    }

    public function test_admin_can_access_employees_page_under_various_admin_roles(): void
    {
        // 1. Employee with role column 'admin'
        $admin1 = Employee::create([
            'name' => 'Admin Column',
            'email' => 'admin1@qmtnjd.test',
            'password' => 'secret123',
            'role' => 'admin',
            'sales_type' => 'none',
            'is_active' => true,
        ]);
        Auth::guard('employee')->setUser($admin1);
        $this->assertTrue(EmployeeResource::canViewAny());

        // 2. Employee with role column 'super_admin'
        $admin2 = Employee::create([
            'name' => 'Super Admin Column',
            'email' => 'admin2@qmtnjd.test',
            'password' => 'secret123',
            'role' => 'super_admin',
            'sales_type' => 'none',
            'is_active' => true,
        ]);
        Auth::guard('employee')->setUser($admin2);
        $this->assertTrue(EmployeeResource::canViewAny());

        // 3. Employee with Spatie role 'Super Admin'
        $superAdminRole = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'employee']);
        $admin3 = Employee::create([
            'name' => 'Super Admin Spatie',
            'email' => 'admin3@qmtnjd.test',
            'password' => 'secret123',
            'role' => 'employee',
            'sales_type' => 'none',
            'is_active' => true,
        ]);
        $admin3->assignRole($superAdminRole);
        Auth::guard('employee')->setUser($admin3);
        $this->assertTrue(EmployeeResource::canViewAny());

        // 4. Employee with role column 'مدير'
        $admin4 = Employee::create([
            'name' => 'Arabic Manager',
            'email' => 'admin4@qmtnjd.test',
            'password' => 'secret123',
            'role' => 'مدير',
            'sales_type' => 'none',
            'is_active' => true,
        ]);
        Auth::guard('employee')->setUser($admin4);
        $this->assertTrue(EmployeeResource::canViewAny());
    }

    public function test_auto_assign_distributes_orders_fairly_to_least_loaded_rep(): void
    {
        Setting::updateOrCreate(['key' => 'auto_assign_bookings'], ['value' => '1']);

        // Create permission role for cash & finance
        $cashRole = Role::firstOrCreate(['name' => 'cash-rep-role', 'guard_name' => 'employee']);
        $cashRole->givePermissionTo(['manage-cash-bookings', 'manage-bookings']);

        // Rep A: currently 8 bookings
        $repA = Employee::create([
            'name' => 'Rep A (Low)',
            'email' => 'repa@test.com',
            'password' => 'pass',
            'role' => 'sales_rep',
            'sales_type' => 'cash',
            'is_active' => true,
        ]);
        $repA->assignRole($cashRole);

        // Rep B: currently 16 bookings
        $repB = Employee::create([
            'name' => 'Rep B (Medium)',
            'email' => 'repb@test.com',
            'password' => 'pass',
            'role' => 'sales_rep',
            'sales_type' => 'cash',
            'is_active' => true,
        ]);
        $repB->assignRole($cashRole);

        // Rep C: currently 20 bookings
        $repC = Employee::create([
            'name' => 'Rep C (High)',
            'email' => 'repc@test.com',
            'password' => 'pass',
            'role' => 'sales_rep',
            'sales_type' => 'cash',
            'is_active' => true,
        ]);
        $repC->assignRole($cashRole);

        // Seed existing bookings
        for ($i = 0; $i < 8; $i++) {
            $this->createBooking(['assigned_to' => $repA->id, 'payment_method' => 'cash']);
        }
        for ($i = 0; $i < 16; $i++) {
            $this->createBooking(['assigned_to' => $repB->id, 'payment_method' => 'cash']);
        }
        for ($i = 0; $i < 20; $i++) {
            $this->createBooking(['assigned_to' => $repC->id, 'payment_method' => 'cash']);
        }

        $service = new BookingAssignmentService();

        // New booking comes in: must go to Rep A (since Rep A has 8, lowest)
        $newBooking1 = $this->createBooking(['payment_method' => 'cash', 'assigned_to' => null]);
        $service->autoAssign($newBooking1);

        $this->assertEquals($repA->id, $newBooking1->fresh()->assigned_to);

        // Assign 7 more bookings: ALL must go to Rep A until Rep A has 16
        for ($i = 0; $i < 7; $i++) {
            $b = $this->createBooking(['payment_method' => 'cash', 'assigned_to' => null]);
            $service->autoAssign($b);
            $this->assertEquals($repA->id, $b->fresh()->assigned_to);
        }

        // Now Rep A has 16, Rep B has 16, Rep C has 20
        $this->assertEquals(16, Booking::where('assigned_to', $repA->id)->count());
        $this->assertEquals(16, Booking::where('assigned_to', $repB->id)->count());
        $this->assertEquals(20, Booking::where('assigned_to', $repC->id)->count());

        // Next booking should go to Rep B (since Rep B was not assigned recently)
        $nextBooking = $this->createBooking(['payment_method' => 'cash', 'assigned_to' => null]);
        $service->autoAssign($nextBooking);
        $this->assertEquals($repB->id, $nextBooking->fresh()->assigned_to);
    }

    public function test_bulk_redistribute_balances_orders_equally_among_active_reps(): void
    {
        $role = Role::firstOrCreate(['name' => 'sales-officer', 'guard_name' => 'employee']);
        $role->givePermissionTo(['manage-cash-bookings', 'manage-finance-bookings', 'manage-bookings']);

        $rep1 = Employee::create([
            'name' => 'Sales 1',
            'email' => 'sales1@test.com',
            'password' => 'pass',
            'role' => 'sales_rep',
            'sales_type' => 'all',
            'is_active' => true,
        ]);
        $rep1->assignRole($role);

        $rep2 = Employee::create([
            'name' => 'Sales 2',
            'email' => 'sales2@test.com',
            'password' => 'pass',
            'role' => 'sales_rep',
            'sales_type' => 'all',
            'is_active' => true,
        ]);
        $rep2->assignRole($role);

        // Create 20 unassigned bookings
        $bookings = [];
        for ($i = 0; $i < 20; $i++) {
            $bookings[] = $this->createBooking(['assigned_to' => null, 'payment_method' => 'cash']);
        }

        $service = new BookingAssignmentService();
        $result = $service->redistributeBookings($bookings);

        $this->assertEquals(20, $result['total']);
        $this->assertEquals(20, $result['assigned']);
        $this->assertEquals(10, Booking::where('assigned_to', $rep1->id)->count());
        $this->assertEquals(10, Booking::where('assigned_to', $rep2->id)->count());
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
}
