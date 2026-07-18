<?php

namespace App\Filament\Resources\SafetyFeatureResource\Pages;

use App\Filament\Resources\SafetyFeatureResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSafetyFeatures extends ListRecords
{
    protected static string $resource = SafetyFeatureResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}
