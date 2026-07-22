<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FeatureResource\Pages;
use App\Models\Feature;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class FeatureResource extends Resource
{
    protected static ?string $model = Feature::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-sparkles';

    public static function getNavigationGroup(): ?string
    {
        return __('Catalog');
    }

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 12;

    public static function getModelLabel(): string
    {
        return __('Feature');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Features');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make()->schema([
                Grid::make(2)->schema([
                    Forms\Components\TextInput::make('name_ar')->label(__('Name').' ('.__('Arabic').')')->required()->maxLength(255),
                    Forms\Components\TextInput::make('name_en')->label(__('Name').' ('.__('English').')')->required()->maxLength(255),
                ]),
                Grid::make(2)->schema([
                    Forms\Components\Textarea::make('value_ar')->label(__('Value').' ('.__('Arabic').')')->columnSpanFull(),
                    Forms\Components\Textarea::make('value_en')->label(__('Value').' ('.__('English').')')->columnSpanFull(),
                ]),
                Forms\Components\TextInput::make('icon')->label(__('Icon'))->maxLength(100),
            ]),
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
            'index' => Pages\ListFeatures::route('/'),
            'create' => Pages\CreateFeature::route('/create'),
            'edit' => Pages\EditFeature::route('/{record}/edit'),
        ];
    }
}
