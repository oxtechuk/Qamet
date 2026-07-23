<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeadResource\Pages;
use App\Models\Lead;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class LeadResource extends Resource
{
    protected static ?string $model = Lead::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-users';

    public static function getNavigationGroup(): ?string
    {
        return __('Sales & Customers');
    }

    protected static ?string $recordTitleAttribute = 'client_name';

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
            ->schema([
                Section::make()
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('client_name')->label(__('Client Name'))
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('client_phone')->label(__('Client Phone'))
                                    ->tel()
                                    ->required()
                                    ->maxLength(20),
                            ]),
                        Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('client_email')->label(__('Client Email'))
                                    ->email()
                                    ->maxLength(255),
                                Forms\Components\Select::make('contact_source_id')->label(__('Source'))
                                    ->relationship('contactSource', 'name')
                                    ->searchable()
                                    ->preload(),
                            ]),
                        Grid::make(3)
                            ->schema([
                                Forms\Components\Select::make('status')->label(__('Status'))
                                    ->options([
                                        'new' => __('New'),
                                        'contacted' => __('Contacted'),
                                        'interested' => __('Interested'),
                                        'negotiation' => __('Negotiation'),
                                        'converted' => __('Converted'),
                                        'lost' => __('Lost'),
                                    ])
                                    ->required(),
                                Forms\Components\Select::make('car_id')->label(__('Car'))
                                    ->relationship('car', 'name')
                                    ->searchable()
                                    ->preload(),
                                Forms\Components\Select::make('assigned_to')->label(__('Assigned To'))
                                    ->relationship('assignedTo', 'name')
                                    ->searchable()
                                    ->preload(),
                            ]),
                        Forms\Components\Textarea::make('subject')->label(__('Subject'))
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label(__('ID'))
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('client_name')->label(__('Client Name'))
                    ->searchable()
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('client_phone')->label(__('Client Phone'))
                    ->searchable()
                    ->copyable()
                    ->icon('heroicon-m-phone'),

                Tables\Columns\TextColumn::make('contactSource.name')
                    ->label(__('Source'))
                    ->badge()
                    ->sortable(),

                Tables\Columns\TextColumn::make('car.name')
                    ->label(__('Interested Car'))
                    ->limit(20),

                Tables\Columns\BadgeColumn::make('status')->label(__('Status'))
                    ->colors([
                        'primary' => 'new',
                        'info' => 'contacted',
                        'warning' => 'interested',
                        'warning' => 'negotiation',
                        'success' => 'converted',
                        'danger' => 'lost',
                    ]),

                Tables\Columns\TextColumn::make('assignedTo.name')
                    ->label(__('Assigned'))
                    ->badge()
                    ->sortable(),

                Tables\Columns\TextColumn::make('orders_count')
                    ->label(__('Orders'))
                    ->counts('orders')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')->label(__('Created At'))
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'new' => __('New'),
                        'contacted' => __('Contacted'),
                        'interested' => __('Interested'),
                        'negotiation' => __('Negotiation'),
                        'converted' => __('Converted'),
                        'lost' => __('Lost'),
                    ]),
                Tables\Filters\SelectFilter::make('contact_source_id')
                    ->relationship('contactSource', 'name'),
                Tables\Filters\SelectFilter::make('assigned_to')
                    ->relationship('assignedTo', 'name'),
            ])
            ->actions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLeads::route('/'),
            'create' => Pages\CreateLead::route('/create'),
            'edit' => Pages\EditLead::route('/{record}/edit'),
        ];
    }
}
