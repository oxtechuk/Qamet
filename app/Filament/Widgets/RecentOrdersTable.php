<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Filament\Actions;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentOrdersTable extends BaseWidget
{
    protected static ?int $sort = 7;

    public function getHeading(): ?string
    {
        return __('Recent Orders');
    }

    protected static ?string $heading = null;

    public int|string|array $columnSpan = [
        'xl' => 2,
        'lg' => 2,
        'md' => 2,
        'sm' => 1,
    ];

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Booking::with(['car.brand', 'assignedTo'])->latest()->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label(__('ID'))
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('client_name')
                    ->label(__('Client'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('car.name')
                    ->label(__('Car'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('total_price')
                    ->label(__('Price'))
                    ->money('SAR')
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'primary' => 'new',
                        'info' => 'contacted',
                        'warning' => 'interested',
                        'success' => 'sold',
                        'danger' => 'rejected',
                    ]),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Date'))
                    ->date()
                    ->sortable(),
            ])
            ->actions([
                Actions\Action::make('view')
                    ->icon('heroicon-m-eye')
                    ->url(fn (Booking $record): string => route('filament.admin.resources.bookings.view', $record)),
            ]);
    }
}
