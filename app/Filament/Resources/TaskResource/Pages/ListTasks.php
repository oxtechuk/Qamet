<?php

namespace App\Filament\Resources\TaskResource\Pages;

use App\Filament\Resources\TaskResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListTasks extends ListRecords
{
    protected static string $resource = TaskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->slideOver()
                ->modalWidth('2xl'),
        ];
    }

    public function getTabs(): array
    {
        $today = now()->format('Y-m-d');

        return [
            'today' => Tab::make(__('Today Tasks'))
                ->icon('heroicon-m-calendar-days')
                ->badge(\App\Models\Task::whereDate('due_date', $today)->where('status', '!=', 'done')->count())
                ->badgeColor('warning')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereDate('due_date', $today)),

            'pending' => Tab::make(__('Pending Tasks'))
                ->icon('heroicon-m-clock')
                ->badge(\App\Models\Task::whereIn('status', ['new', 'in_progress'])->count())
                ->badgeColor('info')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereIn('status', ['new', 'in_progress'])),

            'upcoming' => Tab::make(__('Upcoming Tasks'))
                ->icon('heroicon-m-calendar')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereDate('due_date', '>', $today)),

            'all' => Tab::make(__('All Tasks'))
                ->icon('heroicon-m-rectangle-stack'),
        ];
    }

    public function getDefaultTab(): string|int|null
    {
        return 'today';
    }
}
