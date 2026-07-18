<?php

namespace App\Filament\Resources\ContactSourceResource\Pages;

use App\Filament\Resources\ContactSourceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditContactSource extends EditRecord
{
    protected static string $resource = ContactSourceResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}
