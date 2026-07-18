<?php

namespace Tests\Feature\Filament;

use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResourcePagesRenderTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return array<int, array<int, string>>
     */
    public static function resourceUrls(): array
    {
        $slugs = [
            'features',
            'safety-features',
            'specifications',
            'blog-categories',
            'brand-types',
            'car-categories',
            'car-types',
            'contact-sources',
            'calculator-banks',
            'cars',
            'bookings',
            'core-values',
            'why-choose-us-items',
            'gallery-items',
        ];

        $cases = [];

        foreach ($slugs as $slug) {
            $cases["{$slug} index"] = ["/admin/{$slug}"];
            $cases["{$slug} create"] = ["/admin/{$slug}/create"];
        }

        $cases['settings page'] = ['/admin/settings'];

        return $cases;
    }

    /**
     * @dataProvider resourceUrls
     */
    public function test_resource_page_renders(string $url): void
    {
        $this->seed(\Database\Seeders\PermissionSeeder::class);

        $employee = Employee::create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'is_active' => true,
        ]);
        $employee->assignRole('admin');

        config(['app.env' => 'local']);
        $this->actingAs($employee, 'employee');

        $this->get($url)->assertStatus(200);
    }
}
