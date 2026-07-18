<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Employee::firstOrCreate(
            ['email' => 'admin@grmotors.com'],
            [
                'name' => 'Admin',
                'username' => 'admin',
                'password' => bcrypt('password'),
                'phone' => '0500000000',
                'is_active' => true,
            ]
        );

        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'employee']);
        $admin->assignRole('admin');

        $this->command->info('Admin user created: admin@grmotors.com / password');
    }
}
