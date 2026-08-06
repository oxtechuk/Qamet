<?php

namespace App\Filament\Resources\ContactSourceResource\Pages;

use App\Filament\Resources\ContactSourceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListContactSources extends ListRecords
{
    protected static string $resource = ContactSourceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->slideOver()->modalWidth('xl'),
        ];
    }
}
