<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    public function up(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permission = Permission::firstOrCreate([
            'name' => 'view-cars-showcase',
            'guard_name' => 'employee',
        ]);

        // Assign to super-admin role
        $superAdmin = Role::where('name', 'super-admin')
            ->where('guard_name', 'employee')
            ->first();

        if ($superAdmin) {
            $superAdmin->givePermissionTo($permission);
        }
    }

    public function down(): void
    {
        Permission::where('name', 'view-cars-showcase')
            ->where('guard_name', 'employee')
            ->delete();
    }
};
