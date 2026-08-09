<?php

namespace Tests\Feature\Filament;

use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskResourceTest extends TestCase
{
    use RefreshDatabase;

    public function test_tasks_page_loads_successfully(): void
    {
        $this->seed(\Database\Seeders\PermissionSeeder::class);

        $employee = Employee::create([
            'name' => 'Test Admin',
            'username' => 'testadmin',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);
        $employee->assignRole('admin');

        config(['app.env' => 'local']);

        $response = $this->actingAs($employee, 'employee')
            ->get('/admin/tasks');

        $response->assertStatus(200);
    }
}
