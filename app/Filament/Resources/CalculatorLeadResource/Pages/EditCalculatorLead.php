<?php

namespace App\Filament\Resources\CalculatorLeadResource\Pages;

use App\Filament\Resources\CalculatorLeadResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCalculatorLead extends EditRecord
{
    protected static string $resource = CalculatorLeadResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}
