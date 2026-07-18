<?php

namespace App\Filament\Resources\WhyChooseUsItemResource\Pages;

use App\Filament\Resources\WhyChooseUsItemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWhyChooseUsItem extends EditRecord
{
    protected static string $resource = WhyChooseUsItemResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}
