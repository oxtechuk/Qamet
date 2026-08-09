<?php

namespace Tests\Feature\Filament;

use App\Models\Employee;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskResourceTest extends TestCase
{
    use RefreshDatabase;

    public function test_tasks_page_loads_successfully(): void
    {
        $employee = Employee::factory()->create();

        $response = $this->actingAs($employee, 'employee')
            ->get('/admin/tasks');

        $response->assertStatus(200);
    }
}
