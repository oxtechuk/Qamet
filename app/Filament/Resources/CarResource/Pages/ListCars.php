<?php

namespace App\Filament\Resources\CarResource\Pages;

use App\Filament\Resources\CarResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Livewire\Attributes\Url;

class ListCars extends ListRecords
{
    protected static string $resource = CarResource::class;

    #[Url(as: 'view')]
    public string $viewMode = 'table';

    public function mount(): void
    {
        parent::mount();

        if (request()->has('view')) {
            $this->viewMode = request('view') === 'grid' ? 'grid' : 'table';
            session(['cars_view_mode' => $this->viewMode]);
        } else {
            $this->viewMode = session('cars_view_mode', 'table');
        }
    }

    public function toggleViewMode(): void
    {
        $this->viewMode = ($this->viewMode === 'grid') ? 'table' : 'grid';
        session(['cars_view_mode' => $this->viewMode]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('toggle_view')
                ->label(fn (): string => $this->viewMode === 'grid' ? 'عرض كجدول' : 'عرض كبطاقات وشريط')
                ->icon(fn (): string => $this->viewMode === 'grid' ? 'heroicon-o-table-cells' : 'heroicon-o-squares-2x2')
                ->color('warning')
                ->action(fn () => $this->toggleViewMode()),

            Actions\CreateAction::make(),
        ];
    }
}
