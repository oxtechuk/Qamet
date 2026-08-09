<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CarTypeResource\Pages;
use App\Models\CarType;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class CarTypeResource extends Resource
{
    protected static ?string $model = CarType::class;

    protected static string|\BackedEnum|null $navigationIcon = null;

    public static function getNavigationGroup(): ?string
    {
        return 'الكتالوج';
    }

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 3;

    public static function getModelLabel(): string
    {
        return __('Car Type');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Car Types');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->schema([
                Section::make()
                    ->columnSpanFull()
                    ->schema([
                        Grid::make(2)->schema([
                            Forms\Components\TextInput::make('name_ar')->label(__('Name').' ('.__('Arabic').')')->required()->maxLength(255),
                            Forms\Components\TextInput::make('name_en')->label(__('Name').' ('.__('English').')')->required()->maxLength(255),
                        ]),
                        Grid::make(2)->schema([
                            Forms\Components\TextInput::make('sort_order')->label(__('Sort Order'))->numeric()->default(0),
                            Forms\Components\Toggle::make('is_active')->label(__('Active'))->default(true),
                        ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label(__('Name'))->searchable()->sortable(),
                Tables\Columns\TextColumn::make('cars_count')->label(__('Cars'))->counts('cars')->sortable(),
                Tables\Columns\IconColumn::make('is_active')->label(__('Active'))->boolean()->sortable(),
            ])
            ->filters([Tables\Filters\TernaryFilter::make('is_active')])
            ->actions([Actions\EditAction::make()->slideOver()->modalWidth('xl'), Actions\DeleteAction::make()])
            ->bulkActions([Actions\BulkActionGroup::make([Actions\DeleteBulkAction::make()])])
            ->defaultSort('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCarTypes::route('/'),
            'create' => Pages\CreateCarType::route('/create'),
            'edit' => Pages\EditCarType::route('/{record}/edit'),
        ];
    }
}
