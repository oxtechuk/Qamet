<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BrandResource\Pages;
use App\Models\Brand;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class BrandResource extends Resource
{
    protected static ?string $model = Brand::class;

    protected static string|\BackedEnum|null $navigationIcon = null;

    public static function getNavigationGroup(): ?string
    {
        return 'الكتالوج';
    }

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 4;

    public static function getModelLabel(): string
    {
        return __('Brand');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Brands');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
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
                                Forms\Components\Select::make('brand_type_id')->label(__('Brand Type'))
                                    ->relationship('brandType', 'name')
                                    ->searchable()
                                    ->preload(),
                            ]),
                        Grid::make(2)
                            ->schema([
                                Forms\Components\FileUpload::make('logo')->label(__('Logo'))
                                    ->image()
                                    ->disk('public')
                                    ->directory('brands/logos')
                                    ->visibility('public'),
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
                Tables\Columns\ImageColumn::make('logo')->label(__('Logo'))
                    ->circular()
                    ->defaultImageUrl(fn () => asset('images/placeholder-brand.jpg')),
                Tables\Columns\TextColumn::make('name')->label(__('Name'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('brandType.name')
                    ->label(__('Type'))
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('cars_count')
                    ->label(__('Cars'))
                    ->counts('cars')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')->label(__('Active'))
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')->label(__('Created At'))
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('brand_type_id')
                    ->relationship('brandType', 'name'),
                Tables\Filters\TernaryFilter::make('is_active'),
            ])
            ->actions([
                Actions\EditAction::make()->slideOver()->modalWidth('2xl'),
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('name');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBrands::route('/'),
            'create' => Pages\CreateBrand::route('/create'),
            'edit' => Pages\EditBrand::route('/{record}/edit'),
        ];
    }
}
