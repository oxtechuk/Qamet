<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SafetyFeatureResource\Pages;
use App\Models\SafetyFeature;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class SafetyFeatureResource extends Resource
{
    protected static ?string $model = SafetyFeature::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-shield-check';

    public static function getNavigationGroup(): ?string
    {
        return __('Catalog');
    }

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 13;

    public static function getModelLabel(): string
    {
        return __('Safety Feature');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Safety Features');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Forms\Components\TextInput::make('name_ar')->label(__('Name').' ('.__('Arabic').')')->required()->maxLength(255),
            Forms\Components\TextInput::make('name_en')->label(__('Name').' ('.__('English').')')->required()->maxLength(255),
            Forms\Components\TextInput::make('icon')->label(__('Icon'))->maxLength(100),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label(__('Name'))->searchable()->sortable(),
                Tables\Columns\TextColumn::make('icon')->label(__('Icon')),
                Tables\Columns\TextColumn::make('cars_count')->label(__('Cars'))->counts('cars')->sortable(),
            ])
            ->filters([])
            ->actions([Actions\EditAction::make(), Actions\DeleteAction::make()])
            ->bulkActions([Actions\BulkActionGroup::make([Actions\DeleteBulkAction::make()])])
            ->defaultSort('name');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSafetyFeatures::route('/'),
            'create' => Pages\CreateSafetyFeature::route('/create'),
            'edit' => Pages\EditSafetyFeature::route('/{record}/edit'),
        ];
    }
}
