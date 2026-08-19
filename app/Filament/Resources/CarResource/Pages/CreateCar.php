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
        $name = $data['name_en'] ?? '';
        $year = $data['year'] ?? (int) date('Y');

        $slugEn = Car::generateUniqueSlug($name, $year, 'en');
        $slugAr = Car::generateUniqueSlug($data['name_ar'] ?? $name, $year, 'ar');

        $data['slug'] = ['en' => $slugEn, 'ar' => $slugAr];

        if (! empty($data['exterior_colors'])) {
            $data['colors'] = $data['exterior_colors'];
        }

        return $data;
    }

    protected function afterCreate(): void
    {
        $this->syncCarImages($this->record, $this->data['exterior_images'] ?? [], 'exterior');
        $this->syncCarImages($this->record, $this->data['interior_images'] ?? [], 'interior');
    }

    private function syncCarImages(Car $car, mixed $paths, string $type): void
    {
        $paths = is_array($paths) ? $paths : ($paths ? [$paths] : []);

        $car->images()->where('type', $type)->delete();

        foreach (array_values($paths) as $index => $path) {
            if (! is_string($path) || empty($path)) {
                continue;
            }

            $car->images()->create([
                'image_path' => $path,
                'type' => $type,
                'sort_order' => $index,
            ]);
        }
    }
}
