<?php

namespace App\Filament\Widgets;

use App\Models\Car;
use Filament\Actions;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentCarsWidget extends BaseWidget
{
    protected static ?int $sort = 8;

    public function getHeading(): ?string
    {
        return __('Recently Added Cars');
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
                Car::with('brand')->latest()->limit(5)
            )
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->label(__('Image'))
                    ->circular()
                    ->defaultImageUrl(fn () => asset('images/placeholder-car.jpg')),

                Tables\Columns\TextColumn::make('name')
                    ->label(__('Car'))
                    ->searchable()
                    ->limit(20),

                Tables\Columns\TextColumn::make('brand.name')
                    ->label(__('Brand')),

                Tables\Columns\TextColumn::make('year')
                    ->label(__('Year')),

                Tables\Columns\TextColumn::make('cash_price')
                    ->label(__('Price'))
                    ->money('SAR'),

                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean()
                    ->label(__('Featured')),
            ])
            ->actions([
                Actions\Action::make('view')
                    ->icon('heroicon-m-eye')
                    ->url(fn (Car $record): string => route('filament.admin.resources.cars.edit', $record)),
            ]);
    }
}
