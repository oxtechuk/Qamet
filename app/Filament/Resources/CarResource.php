<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CarResource\Pages;
use App\Models\Car;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class CarResource extends Resource
{
    protected static ?string $model = Car::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-truck';

    public static function getNavigationGroup(): ?string
    {
        return __('Catalog');
    }

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 1;

    public static function getModelLabel(): string
    {
        return __('Car');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Cars');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Wizard::make([
                    Step::make(__('Basic Information'))
                        ->icon('heroicon-o-information-circle')
                        ->schema([
                            Section::make()
                                ->schema([
                                    Grid::make(2)
                                        ->schema([
                                            Forms\Components\TextInput::make('name_ar')->label(__('Name').' ('.__('Arabic').')')
                                                ->required()
                                                ->maxLength(255),
                                            Forms\Components\TextInput::make('name_en')->label(__('Name').' ('.__('English').')')
                                                ->required()
                                                ->maxLength(255),
                                            Forms\Components\TextInput::make('model')->label(__('Model'))
                                                ->maxLength(255),
                                        ]),
                                    Grid::make(3)
                                        ->schema([
                                            Forms\Components\Select::make('brand_id')->label(__('Brand'))
                                                ->relationship('brand', 'name')
                                                ->required()
                                                ->searchable()
                                                ->preload(),
                                            Forms\Components\Select::make('car_category_id')->label(__('Car Category'))
                                                ->relationship('category', 'name')
                                                ->searchable()
                                                ->preload(),
                                            Forms\Components\TextInput::make('year')->label(__('Year'))
                                                ->numeric()
                                                ->minValue(1990)
                                                ->maxValue(now()->year + 1),
                                        ]),
                                    Forms\Components\RichEditor::make('description_ar')->label(__('Description').' ('.__('Arabic').')')
                                        ->columnSpanFull(),
                                    Forms\Components\RichEditor::make('description_en')->label(__('Description').' ('.__('English').')')
                                        ->columnSpanFull(),
                                ]),
                        ]),

                    Step::make(__('Pricing'))
                        ->icon('heroicon-o-currency-dollar')
                        ->schema([
                            Section::make()
                                ->schema([
                                    Grid::make(3)
                                        ->schema([
                                            Forms\Components\TextInput::make('cash_price')->label(__('Cash Price'))
                                                ->numeric()
                                                ->prefix(__('SAR'))
                                                ->required(),
                                            Forms\Components\TextInput::make('min_down_payment')->label(__('Min Down Payment'))
                                                ->numeric()
                                                ->prefix(__('SAR')),
                                            Forms\Components\TextInput::make('min_installment')->label(__('Min Installment'))
                                                ->numeric()
                                                ->prefix(__('SAR/month')),
                                        ]),
                                ]),
                        ]),

                    Step::make(__('Specifications'))
                        ->icon('heroicon-o-list-bullet')
                        ->schema([
                            Section::make()
                                ->schema([
                                    Grid::make(3)
                                        ->schema([
                                            Forms\Components\Select::make('specifications')->label(__('Specifications'))
                                                ->relationship('specifications', 'name')
                                                ->multiple()
                                                ->preload()
                                                ->searchable(),
                                            Forms\Components\Select::make('features')->label(__('Features'))
                                                ->relationship('features_list', 'name')
                                                ->multiple()
                                                ->preload()
                                                ->searchable(),
                                            Forms\Components\Select::make('safetyFeatures')->label(__('SafetyFeatures'))
                                                ->relationship('safety_features', 'name')
                                                ->multiple()
                                                ->preload()
                                                ->searchable(),
                                        ]),
                                    Forms\Components\KeyValue::make('specs')->label(__('Specs'))
                                        ->keyLabel(__('Specification'))
                                        ->valueLabel(__('Value'))
                                        ->addActionLabel(__('Add spec')),
                                ]),
                        ]),

                    Step::make(__('Media & Colors'))
                        ->icon('heroicon-o-photo')
                        ->schema([
                            Section::make()
                                ->schema([
                                    Forms\Components\FileUpload::make('thumbnail')->label(__('Thumbnail'))
                                        ->image()
                                        ->directory('cars/thumbnails')
                                        ->visibility('public'),
                                    Forms\Components\Repeater::make('colors')->label(__('Colors'))
                                        ->schema([
                                            Grid::make(3)
                                                ->schema([
                                                    Forms\Components\TextInput::make('name')
                                                        ->required(),
                                                    Forms\Components\ColorPicker::make('hex')->label(__('Hex'))
                                                        ->required(),
                                                    Forms\Components\FileUpload::make('image')->label(__('Image'))
                                                        ->image()
                                                        ->directory('cars/colors')
                                                        ->visibility('public'),
                                                ]),
                                        ])
                                        ->addActionLabel(__('Add Color')),
                                ]),
                        ]),

                    Step::make(__('Settings'))
                        ->icon('heroicon-o-cog-6-tooth')
                        ->schema([
                            Section::make()
                                ->schema([
                                    Grid::make(3)
                                        ->schema([
                                            Forms\Components\Toggle::make('is_featured')
                                                ->label(__('Featured Car')),
                                            Forms\Components\Toggle::make('is_active')
                                                ->label(__('Active'))
                                                ->default(true),
                                            Forms\Components\Select::make('availability_status')->label(__('Availability Status'))
                                                ->options([
                                                    'available' => __('Available'),
                                                    'sold' => __('Sold'),
                                                    'reserved' => __('Reserved'),
                                                    'coming_soon' => __('Coming Soon'),
                                                ])
                                                ->default('available'),
                                        ]),
                                ]),
                        ]),
                ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail')->label(__('Thumbnail'))
                    ->circular()
                    ->defaultImageUrl(fn () => asset('images/placeholder-car.jpg')),

                Tables\Columns\TextColumn::make('name')->label(__('Name'))
                    ->searchable()
                    ->sortable()
                    ->limit(30)
                    ->searchable(),

                Tables\Columns\TextColumn::make('brand.name')->label(__('Brand'))
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('year')->label(__('Year'))
                    ->sortable(),

                Tables\Columns\TextColumn::make('cash_price')->label(__('Cash Price'))
                    ->money('SAR')
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('availability_status')->label(__('Availability Status'))
                    ->colors([
                        'success' => 'available',
                        'danger' => 'sold',
                        'warning' => 'reserved',
                        'info' => 'coming_soon',
                    ]),

                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean()
                    ->label(__('Featured'))
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')->label(__('Created At'))
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('brand_id')
                    ->relationship('brand', 'name')
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('availability_status')
                    ->options([
                        'available' => __('Available'),
                        'sold' => __('Sold'),
                        'reserved' => __('Reserved'),
                        'coming_soon' => __('Coming Soon'),
                    ]),
                Tables\Filters\SelectFilter::make('car_category_id')
                    ->relationship('category', 'name'),
                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label(__('Featured')),
            ])
            ->actions([
                Actions\ViewAction::make(),
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->groups([
                Tables\Grouping\Group::make('brand.name'),
                Tables\Grouping\Group::make('availability_status'),
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
            'index' => Pages\ListCars::route('/'),
            'create' => Pages\CreateCar::route('/create'),
            'edit' => Pages\EditCar::route('/{record}/edit'),
        ];
    }
}
