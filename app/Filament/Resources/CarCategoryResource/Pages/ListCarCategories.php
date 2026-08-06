<?php

namespace App\Filament\Resources\CarCategoryResource\Pages;

use App\Filament\Resources\CarCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCarCategories extends ListRecords
{
    protected static string $resource = CarCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->slideOver()->modalWidth('xl'),
        ];
    }
}
