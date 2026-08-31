<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectDesignResource\Pages;
use App\Models\ProjectDesign;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class ProjectDesignResource extends Resource
{
    use \App\Traits\HasResourcePermission;

    protected static string|array|null $permission = 'manage-designs';

    protected static ?string $model = ProjectDesign::class;

    protected static string|\BackedEnum|null $navigationIcon = null;

    public static function getNavigationGroup(): ?string
    {
        return 'المحتوى';
    }

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 9;

    public static function getModelLabel(): string
    {
        return __('Design');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Designs');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make()->schema([
                Forms\Components\TextInput::make('name_ar')->label(__('Name').' ('.__('Arabic').')')->required()->maxLength(255),
                Forms\Components\TextInput::make('name_en')->label(__('Name').' ('.__('English').')')->required()->maxLength(255),
                Forms\Components\Select::make('type')->label(__('Type'))
                    ->options(['interior' => __('Interior'), 'exterior' => __('Exterior'), 'concept' => __('Concept')])
                    ->required(),
                Forms\Components\FileUpload::make('image')->label(__('Image'))->image()->directory('designs')->required(),
                Grid::make(3)->schema([
                    Forms\Components\TextInput::make('price')->label(__('Price'))->numeric()->prefix(__('SAR')),
                    Forms\Components\TextInput::make('top_speed')->label(__('Top Speed'))->numeric()->suffix(__('km/h')),
                    Forms\Components\TextInput::make('power')->label(__('Power'))->numeric()->suffix(__('HP')),
                ]),
                Grid::make(3)->schema([
                    Forms\Components\TextInput::make('year')->label(__('Year'))->numeric(),
                    Forms\Components\TextInput::make('badge_text')->label(__('Badge Text'))->maxLength(100),
                    Forms\Components\ColorPicker::make('color')->label(__('Color')),
                ]),
                Grid::make(2)->schema([
                    Forms\Components\TextInput::make('link')->label(__('Link'))->url()->maxLength(255),
                    Forms\Components\TextInput::make('sort_order')->label(__('Sort Order'))->numeric()->default(0),
                ]),
                Forms\Components\Toggle::make('is_featured')->label(__('Featured')),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')->label(__('Image'))->width(80)->height(60),
                Tables\Columns\TextColumn::make('name')->label(__('Name'))->searchable()->sortable(),
                Tables\Columns\BadgeColumn::make('type')->label(__('Type'))->colors(['primary' => 'interior', 'success' => 'exterior', 'warning' => 'concept']),
                Tables\Columns\TextColumn::make('price')->label(__('Price'))->money('SAR')->sortable(),
                Tables\Columns\IconColumn::make('is_featured')->label(__('Featured'))->boolean()->sortable(),
                Tables\Columns\TextColumn::make('sort_order')->label(__('Sort Order'))->numeric()->sortable(),
            ])
            ->filters([Tables\Filters\SelectFilter::make('type'), Tables\Filters\TernaryFilter::make('is_featured')])
            ->actions([Actions\EditAction::make(), Actions\DeleteAction::make()])
            ->bulkActions([Actions\BulkActionGroup::make([Actions\DeleteBulkAction::make()])])
            ->defaultSort('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjectDesigns::route('/'),
            'create' => Pages\CreateProjectDesign::route('/create'),
            'edit' => Pages\EditProjectDesign::route('/{record}/edit'),
        ];
    }
}
