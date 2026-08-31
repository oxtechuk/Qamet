<?php

namespace App\Filament\Resources\BookingResource\Pages;

use App\Filament\Resources\BookingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ListBookings extends ListRecords
{
    protected static string $resource = BookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        $baseQuery = $this->getTableQuery();

        return [
            'all' => Tab::make('كل الطلبات')
                ->badge((clone $baseQuery)->count()),

            'cash' => Tab::make('طلبات الكاش')
                ->icon('heroicon-m-banknotes')
                ->modifyQueryUsing(fn (Builder $query) => $query->cash())
                ->badge((clone $baseQuery)->cash()->count()),

            'finance' => Tab::make('طلبات التقسيط')
                ->icon('heroicon-m-credit-card')
                ->modifyQueryUsing(fn (Builder $query) => $query->finance())
                ->badge((clone $baseQuery)->finance()->count()),

            'corporate' => Tab::make('تمويل الشركات')
                ->icon('heroicon-m-building-office-2')
                ->modifyQueryUsing(fn (Builder $query) => $query->corporate())
                ->badge((clone $baseQuery)->corporate()->count()),

            'under_review' => Tab::make('طلبات المراجعة')
                ->icon('heroicon-m-exclamation-triangle')
                ->modifyQueryUsing(fn (Builder $query) => $query->underReview())
                ->badge((clone $baseQuery)->underReview()->count())
                ->badgeColor('danger'),

            'completed' => Tab::make('طلبات مكتملة')
                ->icon('heroicon-m-check-badge')
                ->modifyQueryUsing(fn (Builder $query) => $query->completed())
                ->badge((clone $baseQuery)->completed()->count()),

            'cancelled' => Tab::make('طلبات ملغية ومرفوضة')
                ->icon('heroicon-m-x-circle')
                ->modifyQueryUsing(fn (Builder $query) => $query->cancelled())
                ->badge((clone $baseQuery)->cancelled()->count()),
        ];
    }

    public function table(Table $table): Table
    {
        return parent::table($table)
            ->contentGrid([
                'default' => 1,
                'md' => 2,
                'xl' => 3,
            ]);
    }
}
