<?php

namespace App\Filament\Resources\BrandTypeResource\Pages;

use App\Filament\Resources\BrandTypeResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateBrandType extends CreateRecord
{
    protected static string $resource = BrandTypeResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['slug'] = Str::slug(($data['name_en'] ?? '').'-'.uniqid());

        return $data;
    }
}
