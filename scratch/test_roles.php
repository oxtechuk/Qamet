<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Employee;
use Spatie\Permission\Models\Role;

echo "--- Seeding Employee Guard Roles ---\n";
try {
    Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'employee']);
    Role::firstOrCreate(['name' => 'sales', 'guard_name' => 'employee']);
    Role::firstOrCreate(['name' => 'sales-rep', 'guard_name' => 'employee']);
    echo "Employee guard roles seeded successfully!\n";
} catch (\Exception $e) {
    echo 'Error seeding roles: '.$e->getMessage()."\n";
}

echo "\n--- Check if Role assign works ---\n";
try {
    $emp = Employee::first();
    if ($emp) {
        echo "Found employee: {$emp->name} with role {$emp->role}\n";
        $emp->assignRole('admin');
        echo "Assigned role 'admin' successfully!\n";
    } else {
        echo "No employees found.\n";
    }
} catch (\Exception $e) {
    echo 'Error: '.$e->getMessage()."\n";
}

echo "\nRoles in database:\n";
foreach (Role::all() as $role) {
    echo "ID: {$role->id}, Name: {$role->name}, Guard: {$role->guard_name}\n";
}
