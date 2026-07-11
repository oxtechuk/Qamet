<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'employee']);
        $superAdminRole->syncPermissions(Permission::where('guard_name', 'employee')->get());

        $admin = Employee::query()->updateOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Admin',
                'email' => 'admin@knoz.com',
                'password' => 'Admin@123',
                'phone' => '0500000000',
                'role' => 'admin',
                'is_active' => true,
            ],
        );

        $admin->assignRole('super-admin');
    }
}
