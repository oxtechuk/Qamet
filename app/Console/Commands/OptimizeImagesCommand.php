<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\Media\ImageOptimizationService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Finder\SplFileInfo;

class OptimizeImagesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:optimize
                            {--dir= : Subdirectory under storage/app/public to optimize (e.g. cars, slides, blog)}
                            {--quality=82 : WebP output quality from 1 to 100}
                            {--max-width=1920 : Maximum width in pixels}
                            {--max-height=1920 : Maximum height in pixels}
                            {--replace-original : Replace and delete original PNG/JPG if converted to WebP}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Compress, resize, and optimize storage images to modern lightweight WebP format';

    /**
     * Execute the console command.
     */
    public function handle(ImageOptimizationService $optimizer): int
    {
        $subDir = (string) ($this->option('dir') ?? '');
        $quality = (int) ($this->option('quality') ?? 82);
        $maxWidth = (int) ($this->option('max-width') ?? 1920);
        $maxHeight = (int) ($this->option('max-height') ?? 1920);
        $replaceOriginal = (bool) $this->option('replace-original');

        $basePath = storage_path('app/public' . ($subDir ? '/' . trim($subDir, '/') : ''));

        if (! File::isDirectory($basePath)) {
            $this->error("Directory does not exist: {$basePath}");

            return self::FAILURE;
        }

        $this->info("Scanning images in [{$basePath}]...");

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'bmp'];
        $files = collect(File::allFiles($basePath))
            ->filter(fn (SplFileInfo $file): bool => in_array(strtolower($file->getExtension()), $allowedExtensions));

        if ($files->isEmpty()) {
            $this->warn('No compressible image files found.');

            return self::SUCCESS;
        }

        $this->info("Found {$files->count()} image(s) to process. Optimizing with Quality={$quality}%, MaxWidth={$maxWidth}px...");

        $bar = $this->output->createProgressBar($files->count());
        $bar->start();

        $totalOriginal = 0;
        $totalOptimized = 0;
        $processedCount = 0;

        foreach ($files as $file) {
            $path = $file->getRealPath();
            $result = $optimizer->optimizeExistingFile(
                $path,
                maxWidth: $maxWidth,
                maxHeight: $maxHeight,
                quality: $quality,
                replaceOriginal: $replaceOriginal
            );

            if ($result['success']) {
                $totalOriginal += $result['original_size'];
                $totalOptimized += $result['optimized_size'];
                $processedCount++;
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        $savedBytes = max(0, $totalOriginal - $totalOptimized);
        $percentSaved = $totalOriginal > 0 ? round(($savedBytes / $totalOriginal) * 100, 1) : 0;

        $this->table(
            ['Metric', 'Value'],
            [
                ['Files Processed', (string) $processedCount],
                ['Original Total Size', $this->formatBytes($totalOriginal)],
                ['Optimized Total Size', $this->formatBytes($totalOptimized)],
                ['Saved Space', $this->formatBytes($savedBytes) . " ({$percentSaved}%)"],
            ]
        );

        $this->info('Image optimization completed successfully!');

        return self::SUCCESS;
    }

    /**
     * Format bytes into human readable format.
     */
    private function formatBytes(int $bytes, int $precision = 2): string
    {
        if ($bytes <= 0) {
            return '0 B';
        }

        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $base = log($bytes, 1024);
        $pow = (int) floor($base);

        return round(pow(1024, $base - $pow), $precision) . ' ' . ($units[$pow] ?? 'B');
    }
}
