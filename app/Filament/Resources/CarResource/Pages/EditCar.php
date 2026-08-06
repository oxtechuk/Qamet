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
        $data['exterior_images'] = $this->record->exterior_images;
        $data['interior_images'] = $this->record->interior_images;

        return $data;
    }

    protected function afterSave(): void
    {
        $this->syncCarImages($this->record, $this->data['exterior_images'] ?? [], 'exterior');
        $this->syncCarImages($this->record, $this->data['interior_images'] ?? [], 'interior');
    }

    private function syncCarImages(Car $car, array $paths, string $type): void
    {
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
