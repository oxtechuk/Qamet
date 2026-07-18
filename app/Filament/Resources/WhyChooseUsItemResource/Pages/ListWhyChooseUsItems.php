<?php

namespace App\Filament\Resources\WhyChooseUsItemResource\Pages;

use App\Filament\Resources\WhyChooseUsItemResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWhyChooseUsItems extends ListRecords
{
    protected static string $resource = WhyChooseUsItemResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}
