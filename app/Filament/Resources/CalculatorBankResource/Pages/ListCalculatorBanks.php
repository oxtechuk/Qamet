<?php

namespace App\Filament\Resources\CalculatorBankResource\Pages;

use App\Filament\Resources\CalculatorBankResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCalculatorBanks extends ListRecords
{
    protected static string $resource = CalculatorBankResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}
