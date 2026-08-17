<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OfferResource\Pages;
use App\Models\Offer;
use App\Services\Media\ImageOptimizationService;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class OfferResource extends Resource
{
    protected static ?string $model = Offer::class;

    protected static string|\BackedEnum|null $navigationIcon = null;

    public static function getNavigationGroup(): ?string
    {
        return 'الكتالوج';
    }

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?int $navigationSort = 6;

    public static function getModelLabel(): string
    {
        return __('Offer');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Offers');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make()
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('title_ar')->label(__('Title').' ('.__('Arabic').')')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('title_en')->label(__('Title').' ('.__('English').')')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\Select::make('car_id')->label(__('Car'))
                                    ->relationship('car', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                            ]),
                        Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('discount_percent')->label(__('Discount Percent'))
                                    ->numeric()
                                    ->suffix('%')
                                    ->minValue(0)
                                    ->maxValue(100),
                                Forms\Components\TextInput::make('special_price')->label(__('Special Price'))
                                    ->numeric()
                                    ->prefix(__('SAR')),
                                Forms\Components\TextInput::make('special_installment')->label(__('Special Installment'))
                                    ->numeric()
                                    ->prefix(__('SAR/month')),
                            ]),
                        Grid::make(2)
                            ->schema([
                                Forms\Components\DateTimePicker::make('starts_at')->label(__('Starts At'))
                                    ->required(),
                                Forms\Components\DateTimePicker::make('ends_at')->label(__('Ends At')),
                            ]),
                        Forms\Components\RichEditor::make('description_ar')->label(__('Description').' ('.__('Arabic').')')
                            ->columnSpanFull(),
                        Forms\Components\RichEditor::make('description_en')->label(__('Description').' ('.__('English').')')
                            ->columnSpanFull(),
                        Grid::make(2)
                            ->schema([
                                Forms\Components\FileUpload::make('image')->label(__('Image'))
                                    ->image()
                                    ->disk('public')
                                    ->directory('offers')
                                    ->visibility('public')
                                    ->saveUploadedFileUsing(ImageOptimizationService::makeCallback('offers', 1200, 800, 82)),
                                Forms\Components\Toggle::make('is_active')
                                    ->label(__('Active'))
                                    ->default(true),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')->label(__('Image'))
                    ->circular()
                    ->defaultImageUrl(fn () => asset('images/placeholder-offer.jpg')),
                Tables\Columns\TextColumn::make('title')->label(__('Title'))
                    ->formatStateUsing(fn ($state) => is_array($state) ? ($state[app()->getLocale()] ?? $state['ar'] ?? $state['en'] ?? (reset($state) ?: '')) : (string) $state)
                    ->searchable()
                    ->sortable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('car.name')->label(__('Car'))
                    ->searchable()
                    ->limit(25),
                Tables\Columns\TextColumn::make('discount_percent')
                    ->label(__('Discount'))
                    ->suffix('%')
                    ->badge()
                    ->color('success')
                    ->sortable(),
                Tables\Columns\TextColumn::make('special_price')->label(__('Special Price'))
                    ->money('SAR')
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->label(__('Status'))
                    ->getStateUsing(fn (Offer $record): string => $record->is_active && (! $record->ends_at || $record->ends_at > now()) ? 'active' : 'inactive')
                    ->colors([
                        'success' => 'active',
                        'danger' => 'inactive',
                    ]),
                Tables\Columns\TextColumn::make('starts_at')->label(__('Starts At'))
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ends_at')->label(__('Ends At'))
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active'),
                Tables\Filters\Filter::make('date_range')
                    ->form([
                        Forms\Components\DatePicker::make('starts_from')->label(__('Starts From')),
                        Forms\Components\DatePicker::make('ends_until')->label(__('Ends Until')),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['starts_from'], fn ($q) => $q->where('starts_at', '>=', $data['starts_from']))
                            ->when($data['ends_until'], fn ($q) => $q->where('ends_at', '<=', $data['ends_until']));
                    }),
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
            'index' => Pages\ListOffers::route('/'),
            'create' => Pages\CreateOffer::route('/create'),
            'edit' => Pages\EditOffer::route('/{record}/edit'),
        ];
    }
}
