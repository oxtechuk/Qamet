<?php

namespace App\Filament\Resources\CarCategoryResource\Pages;

use App\Filament\Resources\CarCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCarCategory extends EditRecord
{
    protected static string $resource = CarCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}
