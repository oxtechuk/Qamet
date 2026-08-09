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

    protected static string|\BackedEnum|null $navigationIcon = null;

    public static function getNavigationGroup(): ?string
    {
        return 'الطلبات';
    }

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 2;

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
        return $schema
            ->columns(1)
            ->schema([
                Section::make()
                    ->columnSpanFull()
                    ->schema([
                        Grid::make(2)->schema([
                            Forms\Components\TextInput::make('name')->label(__('Name'))->required()->maxLength(255),
                            Forms\Components\TextInput::make('phone')->label(__('Phone'))->tel()->required()->maxLength(20),
                        ]),
                        Grid::make(2)->schema([
                            Forms\Components\TextInput::make('email')->label(__('Email'))->email(),
                            Forms\Components\TextInput::make('city')->label(__('City')),
                        ]),
                        Grid::make(2)->schema([
                            Forms\Components\TextInput::make('salary')->label(__('Salary'))->numeric()->prefix(__('SAR')),
                            Forms\Components\TextInput::make('monthly_obligations')->label(__('Monthly Obligations'))->numeric()->prefix(__('SAR')),
                        ]),
                        Grid::make(2)->schema([
                            Forms\Components\Select::make('preferred_bank_id')->label(__('Preferred Bank'))->relationship('preferredBank', 'name')->searchable()->preload()->nullable(),
                            Forms\Components\Select::make('car_ids')->label(__('Cars'))->options(fn () => \App\Models\Car::query()->pluck('name', 'id')->toArray())->multiple()->searchable()->preload()->nullable(),
                        ]),
                        Grid::make(2)->schema([
                            Forms\Components\TextInput::make('car_price')->label(__('Car Price'))->numeric()->prefix(__('SAR')),
                            Forms\Components\Textarea::make('notes')->label(__('Notes'))->rows(3),
                        ]),
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
                Tables\Columns\TextColumn::make('email')->label(__('Email'))->limit(20),
                Tables\Columns\TextColumn::make('city')->label(__('City'))->limit(15),
                Tables\Columns\TextColumn::make('preferredBank.name')->label(__('Bank')),
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
