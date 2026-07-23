<?php

namespace App\Filament\Resources\BrandTypeResource\Pages;

use App\Filament\Resources\BrandTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBrandTypes extends ListRecords
{
    protected static string $resource = BrandTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}
