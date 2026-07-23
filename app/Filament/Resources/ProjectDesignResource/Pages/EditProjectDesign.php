<?php

namespace App\Filament\Resources\ProjectDesignResource\Pages;

use App\Filament\Resources\ProjectDesignResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProjectDesign extends EditRecord
{
    protected static string $resource = ProjectDesignResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}
