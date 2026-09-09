<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use App\Filament\Resources\EmployeeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEmployees extends ListRecords
{
    protected static string $resource = EmployeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->slideOver()
                ->modalWidth('4xl')
                ->modalHeading('إضافة موظف جديد')
                ->modalDescription('أدخل بيانات الموظف وحدد الدور والصلاحيات وتخصص المبيعات والتوزيع'),
        ];
    }
}
