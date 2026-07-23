<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HighlightResource\Pages;
use App\Models\Highlight;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class HighlightResource extends Resource
{
    protected static ?string $model = Highlight::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-sparkles';

    public static function getNavigationGroup(): ?string
    {
        return __('Catalog');
    }

    protected static ?string $recordTitleAttribute = 'text_en';

    protected static ?int $navigationSort = 11;

    public static function getModelLabel(): string
    {
        return __('Highlight');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Highlights');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make()->schema([
                Grid::make(2)->schema([
                    Forms\Components\TextInput::make('text_ar')->label(__('Text').' ('.__('Arabic').')')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('text_en')->label(__('Text').' ('.__('English').')')
                        ->required()
                        ->maxLength(255),
                ]),
                Forms\Components\ColorPicker::make('color')->label(__('Color'))
                    ->default('#333333'),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('text_en')->label(__('Text'))->searchable()->sortable(),
                Tables\Columns\TextColumn::make('text_ar')->label(__('Arabic'))->searchable(),
                Tables\Columns\ColorColumn::make('color')->label(__('Color')),
                Tables\Columns\TextColumn::make('cars_count')->label(__('Cars'))->counts('cars')->sortable(),
            ])
            ->actions([Actions\EditAction::make(), Actions\DeleteAction::make()])
            ->bulkActions([Actions\BulkActionGroup::make([Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHighlights::route('/'),
            'create' => Pages\CreateHighlight::route('/create'),
            'edit' => Pages\EditHighlight::route('/{record}/edit'),
        ];
    }
}
