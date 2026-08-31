<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SpecificationResource\Pages;
use App\Models\Specification;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class SpecificationResource extends Resource
{
    use \App\Traits\HasResourcePermission;

    protected static string|array|null $permission = 'manage-specifications';

    protected static ?string $model = Specification::class;

    protected static string|\BackedEnum|null $navigationIcon = null;

    public static function getNavigationGroup(): ?string
    {
        return 'الكتالوج';
    }

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 8;

    public static function getModelLabel(): string
    {
        return __('Specification');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Specifications');
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
            'index' => Pages\ListSpecifications::route('/'),
            'create' => Pages\CreateSpecification::route('/create'),
            'edit' => Pages\EditSpecification::route('/{record}/edit'),
        ];
    }
}
