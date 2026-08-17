<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Services\Media\ImageOptimizationService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImageOptimizationTest extends TestCase
{
    public function test_it_optimizes_and_stores_uploaded_image_as_webp(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('test_car.jpg', 2400, 1600);

        $service = app(ImageOptimizationService::class);
        $storedPath = $service->optimizeAndStore($file, 'cars/test', 'public', 1200, 800, 80);

        $this->assertNotEmpty($storedPath);
        $this->assertStringEndsWith('.webp', $storedPath);
        Storage::disk('public')->assertExists($storedPath);
    }

    public function test_it_optimizes_existing_file_in_storage(): void
    {
        $tempFile = tempnam(sys_get_temp_dir(), 'test_img_') . '.png';

        $img = imagecreatetruecolor(800, 600);
        $color = imagecolorallocate($img, 200, 50, 50);
        imagefilledrectangle($img, 0, 0, 800, 600, $color);
        imagepng($img, $tempFile);
        imagedestroy($img);

        $service = app(ImageOptimizationService::class);
        $result = $service->optimizeExistingFile($tempFile, 400, 300, 80, true);

        $this->assertTrue($result['success']);
        $this->assertGreaterThan(0, $result['original_size']);
        $this->assertGreaterThan(0, $result['optimized_size']);

        if (file_exists($tempFile)) {
            @unlink($tempFile);
        }
        if (isset($result['new_path']) && file_exists($result['new_path'])) {
            @unlink($result['new_path']);
        }
    }

    public function test_optimize_images_command_runs_successfully(): void
    {
        Storage::fake('public');

        $this->artisan('images:optimize', ['--quality' => 80])
            ->assertExitCode(0);
    }
}
