<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Car;
use App\Services\Media\ImageOptimizationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\FileUploadConfiguration;
use Tests\TestCase;

class CarColorAndUploadHandlingTest extends TestCase
{
    use RefreshDatabase;

    public function test_livewire_temporary_upload_disk_is_configured_properly(): void
    {
        $configuredDisk = config('livewire.temporary_file_upload.disk');
        $this->assertNotEmpty($configuredDisk);
        $this->assertNotNull(config("filesystems.disks.{$configuredDisk}"));

        $storage = FileUploadConfiguration::storage();
        $this->assertNotNull($storage);
    }

    public function test_image_optimization_handles_missing_file_gracefully(): void
    {
        $service = app(ImageOptimizationService::class);
        $result = $service->optimizeAndStore('non_existent_file.jpg', 'cars/test', 'public');

        $this->assertSame('', $result);
    }

    public function test_image_optimization_callback_returns_string_for_valid_image(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('exterior.jpg', 800, 600);
        $callback = ImageOptimizationService::makeCallback('cars/exterior-colors', 1400, 1050, 82);

        $path = $callback($file);

        $this->assertNotNull($path);
        $this->assertStringStartsWith('cars/exterior-colors/', $path);
        $this->assertStringEndsWith('.webp', $path);
        Storage::disk('public')->assertExists($path);
    }

    public function test_car_formats_exterior_and_interior_colors_correctly(): void
    {
        $car = new Car([
            'name' => 'Toyota Camry',
            'year' => 2024,
            'cash_price' => 100000,
            'exterior_colors' => [
                [
                    'name' => 'White Pearl',
                    'hex' => '#FFFFFF',
                    'images' => ['cars/exterior-colors/sample1.webp', 'cars/exterior-colors/sample2.webp'],
                ],
            ],
            'interior_colors' => [
                [
                    'name' => 'Tan Leather',
                    'hex' => '#D2B48C',
                    'images' => ['cars/interior-colors/sample_int.webp'],
                ],
            ],
        ]);

        $exteriorColors = $car->formatted_exterior_colors;
        $this->assertIsArray($exteriorColors);
        $this->assertCount(1, $exteriorColors);
        $this->assertSame('White Pearl', $exteriorColors[0]['name']);
        $this->assertCount(2, $exteriorColors[0]['images']);

        $interiorColors = $car->formatted_interior_colors;
        $this->assertIsArray($interiorColors);
        $this->assertCount(1, $interiorColors);
        $this->assertSame('Tan Leather', $interiorColors[0]['name']);
        $this->assertCount(1, $interiorColors[0]['images']);
    }

    public function test_car_legacy_colors_fallback(): void
    {
        $car = new Car([
            'name' => 'Nissan Patrol',
            'year' => 2023,
            'cash_price' => 250000,
            'colors' => [
                [
                    'name' => 'Black',
                    'hex' => '#000000',
                    'image' => 'cars/sample_legacy.jpg',
                ],
            ],
        ]);

        $colors = $car->formatted_exterior_colors;
        $this->assertIsArray($colors);
        $this->assertSame('Black', $colors[0]['name']);
        $this->assertNotEmpty($colors[0]['images']);
    }
}
