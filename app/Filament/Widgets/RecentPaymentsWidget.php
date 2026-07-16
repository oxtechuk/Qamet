<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Filament\Actions;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentPaymentsWidget extends BaseWidget
{
    protected static ?int $sort = 9;

    public function getHeading(): ?string
    {
        return __('Latest Transactions');
    }

    protected static ?string $heading = null;

    public int|string|array $columnSpan = [
        'xl' => 1,
        'lg' => 2,
        'md' => 2,
        'sm' => 1,
    ];

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Booking::whereNotNull('down_payment')->latest()->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('client_name')
                    ->label(__('Client'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('down_payment')
                    ->label(__('Down Payment'))
                    ->money('SAR')
                    ->sortable(),

                Tables\Columns\TextColumn::make('monthly_installment')
                    ->label(__('Monthly'))
                    ->money('SAR'),

                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'success' => 'sold',
                        'warning' => 'interested',
                        'primary' => 'new',
                    ]),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Date'))
                    ->date()
                    ->sortable(),
            ])
            ->actions([
                Actions\Action::make('view')
                    ->icon('heroicon-m-eye')
                    ->url(fn (Booking $record): string => route('filament.admin.resources.bookings.edit', $record)),
            ]);
    }
}
