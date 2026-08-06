<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WhyChooseUsItemResource\Pages;
use App\Models\WhyChooseUsItem;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class WhyChooseUsItemResource extends Resource
{
    protected static ?string $model = WhyChooseUsItem::class;

    protected static string|\BackedEnum|null $navigationIcon = null;

    public static function getNavigationGroup(): ?string
    {
        return 'المحتوى';
    }

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?int $navigationSort = 8;

    public static function getModelLabel(): string
    {
        return __('Why Choose Us Item');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Why Choose Us');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make()->schema([
                Forms\Components\TextInput::make('icon')->label(__('Icon'))->placeholder('heroicon-o-check-badge')->maxLength(100),
                Grid::make(2)->schema([
                    Forms\Components\TextInput::make('title_ar')->label(__('Title').' ('.__('Arabic').')')->required()->maxLength(255),
                    Forms\Components\TextInput::make('title_en')->label(__('Title').' ('.__('English').')')->required()->maxLength(255),
                ]),
                Grid::make(2)->schema([
                    Forms\Components\Textarea::make('description_ar')->label(__('Description').' ('.__('Arabic').')'),
                    Forms\Components\Textarea::make('description_en')->label(__('Description').' ('.__('English').')'),
                ]),
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
                Tables\Columns\TextColumn::make('icon')->label(__('Icon')),
                Tables\Columns\TextColumn::make('title')->label(__('Title'))->searchable()->sortable(),
                Tables\Columns\IconColumn::make('is_active')->label(__('Active'))->boolean()->sortable(),
                Tables\Columns\TextColumn::make('sort_order')->label(__('Sort Order'))->numeric()->sortable(),
            ])
            ->filters([Tables\Filters\TernaryFilter::make('is_active')])
            ->actions([Actions\EditAction::make(), Actions\DeleteAction::make()])
            ->bulkActions([Actions\BulkActionGroup::make([Actions\DeleteBulkAction::make()])])
            ->reorderable('sort_order')
            ->defaultSort('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWhyChooseUsItems::route('/'),
            'create' => Pages\CreateWhyChooseUsItem::route('/create'),
            'edit' => Pages\EditWhyChooseUsItem::route('/{record}/edit'),
        ];
    }
}
