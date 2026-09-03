<?php

namespace App\Filament\Resources\CarResource\Pages;

use App\Filament\Resources\CarResource;
use App\Models\Car;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCar extends EditRecord
{
    protected static string $resource = CarResource::class;

    public function getMaxWidth(): string
    {
        return 'full';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['exterior_images'] = $this->sanitizeImagePaths($this->record->exterior_images);
        $data['interior_images'] = $this->sanitizeImagePaths($this->record->interior_images);

        if (! empty($data['thumbnail']) && (str_contains((string) $data['thumbnail'], 'livewire-tmp') || ! is_string($data['thumbnail']))) {
            $data['thumbnail'] = null;
        }

        $colors = ! empty($data['exterior_colors']) ? $data['exterior_colors'] : $this->record->colors;
        if (is_array($colors)) {
            foreach ($colors as &$color) {
                if (isset($color['images']) && is_array($color['images'])) {
                    $color['images'] = $this->sanitizeImagePaths($color['images']);
                }
            }
            unset($color);
            $data['exterior_colors'] = $colors;
        }

        $interiorColors = $data['interior_colors'] ?? null;
        if (is_array($interiorColors)) {
            foreach ($interiorColors as &$color) {
                if (isset($color['images']) && is_array($color['images'])) {
                    $color['images'] = $this->sanitizeImagePaths($color['images']);
                }
            }
            unset($color);
            $data['interior_colors'] = $interiorColors;
        }

        if (! empty($data['variants']) && is_array($data['variants'])) {
            foreach ($data['variants'] as &$variant) {
                if (isset($variant['image']) && is_string($variant['image']) && str_contains($variant['image'], 'livewire-tmp')) {
                    $variant['image'] = null;
                }
            }
            unset($variant);
        }

        return $data;
    }

    private function sanitizeImagePaths(mixed $paths): array
    {
        if (! is_array($paths)) {
            $paths = $paths ? [$paths] : [];
        }

        return array_values(array_filter($paths, function ($path) {
            return is_string($path) && ! empty($path) && ! str_contains($path, 'livewire-tmp');
        }));
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (isset($data['exterior_colors']) && ! empty($data['exterior_colors'])) {
            $data['colors'] = $data['exterior_colors'];
        }

        return $data;
    }

    protected function afterSave(): void
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
