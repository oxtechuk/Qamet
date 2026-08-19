<?php

namespace App\Filament\Resources\BookingResource\Pages;

use App\Filament\Resources\BookingResource;
use App\Models\Booking;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

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
        return [
            'all' => Tab::make('كل الطلبات')
                ->badge(Booking::count()),

            'cash' => Tab::make('طلبات الكاش')
                ->icon('heroicon-m-banknotes')
                ->modifyQueryUsing(fn (Builder $query) => $query->cash())
                ->badge(Booking::cash()->count()),

            'finance' => Tab::make('طلبات التقسيط')
                ->icon('heroicon-m-credit-card')
                ->modifyQueryUsing(fn (Builder $query) => $query->finance())
                ->badge(Booking::finance()->count()),

            'completed' => Tab::make('طلبات مكتملة')
                ->icon('heroicon-m-check-badge')
                ->modifyQueryUsing(fn (Builder $query) => $query->completed())
                ->badge(Booking::completed()->count()),

            'cancelled' => Tab::make('طلبات ملغية')
                ->icon('heroicon-m-x-circle')
                ->modifyQueryUsing(fn (Builder $query) => $query->cancelled())
                ->badge(Booking::cancelled()->count()),
        ];
    }

    protected function getTableQuery(): Builder
    {
        $query = parent::getTableQuery();
        $user = Auth::guard('employee')->user();

        if ($user && ! $user->isAdmin()) {
            // Sales Rep Scoping
            $query->where(function (Builder $q) use ($user) {
                $q->where('assigned_to', $user->id);

                if ($user->sales_type === 'cash') {
                    $q->orWhere(function ($cashQ) {
                        $cashQ->where('payment_method', 'cash')->whereNull('assigned_to');
                    });
                } elseif ($user->sales_type === 'finance') {
                    $q->orWhere(function ($finQ) {
                        $finQ->where('payment_method', '!=', 'cash')->whereNull('assigned_to');
                    });
                }
            });
        }

        return $query;
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
