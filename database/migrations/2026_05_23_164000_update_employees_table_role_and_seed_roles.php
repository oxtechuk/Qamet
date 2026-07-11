<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Change role column from enum to string
        Schema::table('employees', function (Blueprint $table) {
            $table->string('role')->default('sales')->change();
        });

        // Seed the Spatie roles for the employee guard
        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'employee']);
        Role::firstOrCreate(['name' => 'sales', 'guard_name' => 'employee']);
        Role::firstOrCreate(['name' => 'sales-rep', 'guard_name' => 'employee']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Change role column back to enum
        Schema::table('employees', function (Blueprint $table) {
            $table->enum('role', ['admin', 'sales'])->default('sales')->change();
        });

        // Delete the employee guard roles
        Role::where('guard_name', 'employee')->whereIn('name', ['admin', 'sales', 'sales-rep'])->delete();
    }
};
