<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GalleryItemResource\Pages;
use App\Models\GalleryItem;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class GalleryItemResource extends Resource
{
    protected static ?string $model = GalleryItem::class;

    protected static string|\BackedEnum|null $navigationIcon = null;

    public static function getNavigationGroup(): ?string
    {
        return 'المحتوى';
    }

    protected static ?string $recordTitleAttribute = 'alt_text';

    protected static ?int $navigationSort = 5;

    public static function getModelLabel(): string
    {
        return __('Gallery Item');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Gallery');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make()->schema([
                Forms\Components\Select::make('type')
                    ->label(__('Type'))
                    ->options(['image' => __('Image'), 'video' => __('Video')])
                    ->default('image')
                    ->required()
                    ->live(),
                Forms\Components\FileUpload::make('file')
                    ->label(fn (Get $get): string => $get('type') === 'video' ? __('Video File') : __('Image'))
                    ->image(fn (Get $get): bool => $get('type') !== 'video')
                 //   ->acceptedFileTypes(fn (Get $get): ?array => $get('type') === 'video' ? ['video/mp4'] : null)
                    ->directory(fn (Get $get): string => $get('type') === 'video' ? 'gallery/videos' : 'gallery')
                    ->visibility('public')
                    ->required(),
                Forms\Components\FileUpload::make('thumbnail')
                    ->label(__('Thumbnail'))
                    ->image()
                    ->directory('gallery/thumbnails')
                    ->visibility('public')
                    ->visible(fn (Get $get): bool => $get('type') === 'video'),
                Grid::make(2)->schema([
                    Forms\Components\TextInput::make('caption_ar')->label(__('Caption').' ('.__('Arabic').')'),
                    Forms\Components\TextInput::make('caption_en')->label(__('Caption').' ('.__('English').')'),
                ]),
                Forms\Components\TextInput::make('alt_text')->label(__('Alt Text'))->maxLength(255),
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
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->label(__('Preview'))
                    ->getStateUsing(fn (GalleryItem $record): ?string => $record->type === 'video' ? $record->thumbnail : $record->file),
                Tables\Columns\TextColumn::make('type')->label(__('Type'))->badge()->sortable(),
                Tables\Columns\TextColumn::make('caption')->label(__('Caption'))->limit(30),
                Tables\Columns\IconColumn::make('is_active')->label(__('Active'))->boolean()->sortable(),
                Tables\Columns\TextColumn::make('sort_order')->label(__('Sort Order'))->numeric()->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')->options(['image' => __('Image'), 'video' => __('Video')]),
                Tables\Filters\TernaryFilter::make('is_active'),
            ])
            ->actions([Actions\EditAction::make(), Actions\DeleteAction::make()])
            ->bulkActions([Actions\BulkActionGroup::make([Actions\DeleteBulkAction::make()])])
            ->reorderable('sort_order')
            ->defaultSort('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGalleryItems::route('/'),
            'create' => Pages\CreateGalleryItem::route('/create'),
            'edit' => Pages\EditGalleryItem::route('/{record}/edit'),
        ];
    }
}
