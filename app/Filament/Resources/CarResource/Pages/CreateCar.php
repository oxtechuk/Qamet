<?php

namespace App\Filament\Resources\CarResource\Pages;

use App\Filament\Resources\CarResource;
use App\Models\Car;
use Filament\Resources\Pages\CreateRecord;

class CreateCar extends CreateRecord
{
    protected static string $resource = CarResource::class;

    public function getMaxWidth(): string
    {
        return 'full';
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // 1. Sanitize thumbnail
        if (! empty($data['thumbnail']) && (str_contains((string) $data['thumbnail'], 'livewire-tmp') || ! is_string($data['thumbnail']))) {
            $data['thumbnail'] = null;
        }

        // 2. Sanitize general images
        $data['exterior_images'] = $this->sanitizeImagePaths($data['exterior_images'] ?? []);
        $data['interior_images'] = $this->sanitizeImagePaths($data['interior_images'] ?? []);

        // 3. Sanitize exterior colors
        $colors = $data['exterior_colors'] ?? $data['colors'] ?? null;
        if (is_array($colors)) {
            foreach ($colors as &$color) {
                if (isset($color['images']) && is_array($color['images'])) {
                    $color['images'] = $this->sanitizeImagePaths($color['images']);
                }
            }
            unset($color);
            $data['exterior_colors'] = $colors;
            $data['colors'] = $colors;
        }

        // 4. Sanitize interior colors
        if (! empty($data['interior_colors']) && is_array($data['interior_colors'])) {
            foreach ($data['interior_colors'] as &$color) {
                if (isset($color['images']) && is_array($color['images'])) {
                    $color['images'] = $this->sanitizeImagePaths($color['images']);
                }
            }
            unset($color);
        }

        // 5. Sanitize variants
        if (! empty($data['variants']) && is_array($data['variants'])) {
            foreach ($data['variants'] as &$variant) {
                if (isset($variant['image']) && is_string($variant['image']) && str_contains($variant['image'], 'livewire-tmp')) {
                    $variant['image'] = null;
                }
            }
            unset($variant);
        }

        $name = $data['name_en'] ?? '';
        $year = $data['year'] ?? (int) date('Y');

        $slugEn = Car::generateUniqueSlug($name, $year, 'en');
        $slugAr = Car::generateUniqueSlug($data['name_ar'] ?? $name, $year, 'ar');

        $data['slug'] = ['en' => $slugEn, 'ar' => $slugAr];

        return $data;
    }

    protected function afterCreate(): void
    {
        $this->syncCarImages($this->record, $this->data['exterior_images'] ?? [], 'exterior');
        $this->syncCarImages($this->record, $this->data['interior_images'] ?? [], 'interior');
    }

    private function syncCarImages(Car $car, mixed $paths, string $type): void
    {
        $paths = $this->sanitizeImagePaths($paths);

        $car->images()->where('type', $type)->delete();

        foreach (array_values($paths) as $index => $path) {
            $car->images()->create([
                'image_path' => $path,
                'type' => $type,
                'sort_order' => $index,
            ]);
        }
    }

    private function sanitizeImagePaths(mixed $paths): array
    {
        if (empty($paths) || ! is_array($paths)) {
            return [];
        }

        return array_values(array_filter($paths, function ($path) {
            return is_string($path)
                && ! empty($path)
                && ! str_contains($path, 'livewire-tmp')
                && trim($path) !== 'livewire-tmp';
        }));
    }
}
