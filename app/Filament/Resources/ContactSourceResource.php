<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactSourceResource\Pages;
use App\Models\ContactSource;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class ContactSourceResource extends Resource
{
    protected static ?string $model = ContactSource::class;

    protected static string|\BackedEnum|null $navigationIcon = null;

    public static function getNavigationGroup(): ?string
    {
        return 'العملاء';
    }

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 2;

    public static function getModelLabel(): string
    {
        return __('Source');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Sources');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make()->schema([
                Forms\Components\TextInput::make('name')->label(__('Name'))->required()->maxLength(255),
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
                Tables\Columns\IconColumn::make('is_active')->label(__('Active'))->boolean()->sortable(),
                Tables\Columns\TextColumn::make('sort_order')->label(__('Sort Order'))->numeric()->sortable(),
            ])
            ->filters([Tables\Filters\TernaryFilter::make('is_active')])
            ->actions([Actions\EditAction::make()->slideOver()->modalWidth('xl'), Actions\DeleteAction::make()])
            ->bulkActions([Actions\BulkActionGroup::make([Actions\DeleteBulkAction::make()])])
            ->defaultSort('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContactSources::route('/'),
            'create' => Pages\CreateContactSource::route('/create'),
            'edit' => Pages\EditContactSource::route('/{record}/edit'),
        ];
    }
}
