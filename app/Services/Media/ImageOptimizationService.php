<?php

declare(strict_types=1);

namespace App\Services\Media;

use Closure;
use GdImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ImageOptimizationService
{
    /**
     * Optimize an uploaded file (from Filament, Livewire, or Request) and store it as a compressed WebP.
     */
    public function optimizeAndStore(
        UploadedFile|TemporaryUploadedFile|string $file,
        string $directory,
        string $disk = 'public',
        int $maxWidth = 1920,
        int $maxHeight = 1920,
        int $quality = 82
    ): string {
        $realPath = is_string($file) ? $file : $file->getRealPath();

        if (! file_exists($realPath) || ! is_readable($realPath)) {
            // Fallback to default store if file not directly readable
            if ($file instanceof UploadedFile || $file instanceof TemporaryUploadedFile) {
                return $file->store($directory, $disk);
            }

            return '';
        }

        $image = $this->createGdImage($realPath);

        if (! $image) {
            // If GD cannot process (e.g. SVG or unsupported), save as-is
            if ($file instanceof UploadedFile || $file instanceof TemporaryUploadedFile) {
                return $file->store($directory, $disk);
            }

            return '';
        }

        $origWidth = imagesx($image);
        $origHeight = imagesy($image);

        // Calculate new dimensions preserving aspect ratio
        [$newWidth, $newHeight] = $this->calculateTargetDimensions($origWidth, $origHeight, $maxWidth, $maxHeight);

        // Create canvas with proper dimensions
        $targetCanvas = imagecreatetruecolor($newWidth, $newHeight);

        // Preserve alpha transparency for PNG / WebP
        imagealphablending($targetCanvas, false);
        imagesavealpha($targetCanvas, true);
        $transparent = imagecolorallocatealpha($targetCanvas, 255, 255, 255, 127);
        imagefilledrectangle($targetCanvas, 0, 0, $newWidth, $newHeight, $transparent);

        // Resample with high quality
        imagecopyresampled(
            $targetCanvas,
            $image,
            0, 0, 0, 0,
            $newWidth, $newHeight,
            $origWidth, $origHeight
        );

        // Save output to temporary file
        $tempPath = tempnam(sys_get_temp_dir(), 'opt_img_').'.webp';
        imagewebp($targetCanvas, $tempPath, $quality);

        imagedestroy($image);
        imagedestroy($targetCanvas);

        // Generate target filename and store on disk
        $filename = Str::random(40).'.webp';
        $targetPath = trim($directory, '/').'/'.$filename;

        $stream = fopen($tempPath, 'r');
        Storage::disk($disk)->put($targetPath, $stream, 'public');

        if (is_resource($stream)) {
            fclose($stream);
        }

        if (file_exists($tempPath)) {
            @unlink($tempPath);
        }

        return $targetPath;
    }

    /**
     * Optimize an existing file in-place or convert it to WebP.
     *
     * @return array{success: bool, original_size: int, optimized_size: int, saved_bytes: int, new_path?: string}
     */
    public function optimizeExistingFile(
        string $absolutePath,
        int $maxWidth = 1920,
        int $maxHeight = 1920,
        int $quality = 82,
        bool $replaceOriginal = false
    ): array {
        if (! file_exists($absolutePath) || ! is_readable($absolutePath)) {
            return ['success' => false, 'original_size' => 0, 'optimized_size' => 0, 'saved_bytes' => 0];
        }

        $originalSize = (int) filesize($absolutePath);
        $extension = strtolower(pathinfo($absolutePath, PATHINFO_EXTENSION));

        // Don't process non-image or SVG files
        if (in_array($extension, ['svg', 'ico', 'pdf', 'mp4', 'mov', 'json'])) {
            return ['success' => false, 'original_size' => $originalSize, 'optimized_size' => $originalSize, 'saved_bytes' => 0];
        }

        $image = $this->createGdImage($absolutePath);

        if (! $image) {
            return ['success' => false, 'original_size' => $originalSize, 'optimized_size' => $originalSize, 'saved_bytes' => 0];
        }

        $origWidth = imagesx($image);
        $origHeight = imagesy($image);

        [$newWidth, $newHeight] = $this->calculateTargetDimensions($origWidth, $origHeight, $maxWidth, $maxHeight);

        $targetCanvas = imagecreatetruecolor($newWidth, $newHeight);
        imagealphablending($targetCanvas, false);
        imagesavealpha($targetCanvas, true);
        $transparent = imagecolorallocatealpha($targetCanvas, 255, 255, 255, 127);
        imagefilledrectangle($targetCanvas, 0, 0, $newWidth, $newHeight, $transparent);

        imagecopyresampled(
            $targetCanvas,
            $image,
            0, 0, 0, 0,
            $newWidth, $newHeight,
            $origWidth, $origHeight
        );

        $outputPath = $absolutePath;
        if (! $replaceOriginal && $extension !== 'webp') {
            $outputPath = pathinfo($absolutePath, PATHINFO_DIRNAME).'/'.pathinfo($absolutePath, PATHINFO_FILENAME).'.webp';
        }

        $tempPath = tempnam(sys_get_temp_dir(), 'opt_existing_').'.webp';
        imagewebp($targetCanvas, $tempPath, $quality);

        imagedestroy($image);
        imagedestroy($targetCanvas);

        $newSize = (int) filesize($tempPath);

        // If optimized size is smaller or converted to webp
        if ($newSize < $originalSize || $extension !== 'webp') {
            rename($tempPath, $outputPath);

            // If we converted file.png to file.webp and want to cleanup original
            if ($replaceOriginal && $outputPath !== $absolutePath && file_exists($absolutePath)) {
                @unlink($absolutePath);
            }

            return [
                'success' => true,
                'original_size' => $originalSize,
                'optimized_size' => $newSize,
                'saved_bytes' => max(0, $originalSize - $newSize),
                'new_path' => $outputPath,
            ];
        }

        if (file_exists($tempPath)) {
            @unlink($tempPath);
        }

        return [
            'success' => true,
            'original_size' => $originalSize,
            'optimized_size' => $originalSize,
            'saved_bytes' => 0,
            'new_path' => $absolutePath,
        ];
    }

    /**
     * Create a Filament saveUploadedFileUsing closure.
     */
    public static function makeCallback(
        string $directory,
        int $maxWidth = 1920,
        int $maxHeight = 1920,
        int $quality = 82,
        string $disk = 'public'
    ): Closure {
        return function (UploadedFile|TemporaryUploadedFile $file) use ($directory, $maxWidth, $maxHeight, $quality, $disk): string {
            $service = app(self::class);

            return $service->optimizeAndStore($file, $directory, $disk, $maxWidth, $maxHeight, $quality);
        };
    }

    /**
     * Helper to load image resource from path.
     */
    private function createGdImage(string $path): ?GdImage
    {
        $raw = @file_get_contents($path);

        if ($raw === false || strlen($raw) === 0) {
            return null;
        }

        $image = @imagecreatefromstring($raw);

        return $image instanceof GdImage ? $image : null;
    }

    /**
     * Calculate target dimensions keeping aspect ratio.
     *
     * @return array{0: int, 1: int}
     */
    private function calculateTargetDimensions(int $width, int $height, int $maxWidth, int $maxHeight): array
    {
        if ($width <= $maxWidth && $height <= $maxHeight) {
            return [$width, $height];
        }

        $ratio = min($maxWidth / $width, $maxHeight / $height);

        $newWidth = max(1, (int) round($width * $ratio));
        $newHeight = max(1, (int) round($height * $ratio));

        return [$newWidth, $newHeight];
    }
}
