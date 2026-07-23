<?php

namespace App\Filament\Resources\CarTypeResource\Pages;

use App\Filament\Resources\CarTypeResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateCarType extends CreateRecord
{
    protected static string $resource = CarTypeResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['slug'] = Str::slug(($data['name_en'] ?? '').'-'.uniqid());

        return $data;
    }
}
