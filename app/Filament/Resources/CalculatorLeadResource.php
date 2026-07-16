<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CalculatorLeadResource\Pages;
use App\Models\CalculatorLead;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class CalculatorLeadResource extends Resource
{
    protected static ?string $model = CalculatorLead::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-calculator';

    public static function getNavigationGroup(): ?string
    {
        return __('Sales & Customers');
    }

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 5;

    public static function getModelLabel(): string
    {
        return __('Lead');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Leads');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make()->schema([
                Grid::make(2)->schema([
                    Forms\Components\TextInput::make('name')->label(__('Name'))->required()->maxLength(255),
                    Forms\Components\TextInput::make('phone')->label(__('Phone'))->tel()->required()->maxLength(20),
                ]),
                Forms\Components\Select::make('car_id')->label(__('Car'))->relationship('car', 'name')->searchable()->preload(),
                Forms\Components\KeyValue::make('details')->label(__('Details'))->keyLabel(__('Field'))->valueLabel(__('Value')),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label(__('Name'))->searchable()->sortable(),
                Tables\Columns\TextColumn::make('phone')->label(__('Phone'))->searchable()->copyable(),
                Tables\Columns\TextColumn::make('car.name')->label(__('Car'))->limit(20),
                Tables\Columns\TextColumn::make('created_at')->label(__('Created At'))->dateTime()->sortable(),
            ])
            ->filters([])
            ->actions([Actions\ViewAction::make(), Actions\DeleteAction::make()])
            ->bulkActions([Actions\BulkActionGroup::make([Actions\DeleteBulkAction::make()])])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCalculatorLeads::route('/'),
            'edit' => Pages\EditCalculatorLead::route('/{record}/edit'),
        ];
    }
}
