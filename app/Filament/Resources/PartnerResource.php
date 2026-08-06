<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PartnerResource\Pages;
use App\Models\Partner;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class PartnerResource extends Resource
{
    protected static ?string $model = Partner::class;

    protected static string|\BackedEnum|null $navigationIcon = null;

    public static function getNavigationGroup(): ?string
    {
        return 'المحتوى';
    }

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 6;

    public static function getModelLabel(): string
    {
        return __('Partner');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Partners');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make()->schema([
                Grid::make(2)->schema([
                    Forms\Components\TextInput::make('name')->label(__('Name'))->required()->maxLength(255),
                    Forms\Components\TextInput::make('link')->label(__('Link'))->url()->maxLength(255),
                ]),
                Grid::make(2)->schema([
                    Forms\Components\FileUpload::make('logo')->label(__('Logo'))->image()->directory('partners')->required(),
                    Forms\Components\TextInput::make('sort_order')->label(__('Sort Order'))->numeric()->default(0),
                ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('logo')->label(__('Logo'))->circular()->width(50)->height(50),
                Tables\Columns\TextColumn::make('name')->label(__('Name'))->searchable()->sortable(),
                Tables\Columns\TextColumn::make('link')->label(__('Link'))->limit(30)->copyable(),
                Tables\Columns\TextColumn::make('sort_order')->label(__('Sort Order'))->numeric()->sortable(),
            ])
            ->filters([])
            ->actions([Actions\EditAction::make(), Actions\DeleteAction::make()])
            ->bulkActions([Actions\BulkActionGroup::make([Actions\DeleteBulkAction::make()])])
            ->defaultSort('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPartners::route('/'),
            'create' => Pages\CreatePartner::route('/create'),
            'edit' => Pages\EditPartner::route('/{record}/edit'),
        ];
    }
}
