<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestimonialResource\Pages;
use App\Models\Testimonial;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class TestimonialResource extends Resource
{
    protected static ?string $model = Testimonial::class;

    protected static string|\BackedEnum|null $navigationIcon = null;

    public static function getNavigationGroup(): ?string
    {
        return 'المحتوى';
    }

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 3;

    public static function getModelLabel(): string
    {
        return __('Testimonial');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Testimonials');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make()->schema([
                Grid::make(2)->schema([
                    Forms\Components\TextInput::make('name_ar')->label(__('Name').' ('.__('Arabic').')')->required()->maxLength(255),
                    Forms\Components\TextInput::make('name_en')->label(__('Name').' ('.__('English').')')->required()->maxLength(255),
                    Forms\Components\TextInput::make('title_ar')->label(__('Title').' ('.__('Arabic').')')->maxLength(255),
                    Forms\Components\TextInput::make('title_en')->label(__('Title').' ('.__('English').')')->maxLength(255),
                ]),
                Grid::make(2)->schema([
                    Forms\Components\FileUpload::make('image')->label(__('Image'))->image()->disk('public')->directory('testimonials')->visibility('public'),
                    Forms\Components\FileUpload::make('review_image')->label(__('Review Image'))->image()->disk('public')->directory('testimonials/reviews')->visibility('public'),
                ]),
                Forms\Components\Textarea::make('content_ar')->label(__('Content').' ('.__('Arabic').')')->columnSpanFull(),
                Forms\Components\Textarea::make('content_en')->label(__('Content').' ('.__('English').')')->columnSpanFull(),
                Grid::make(3)->schema([
                    Forms\Components\TextInput::make('rating')->label(__('Rating'))->numeric()->minValue(1)->maxValue(5)->default(5),
                    Forms\Components\TextInput::make('sort_order')->label(__('Sort Order'))->numeric()->default(0),
                    Forms\Components\Toggle::make('is_visible')->label(__('Visible'))->default(true),
                ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')->label(__('Image'))->circular()->defaultImageUrl(fn ($r) => 'https://ui-avatars.com/api/?name='.urlencode($r->name)),
                Tables\Columns\TextColumn::make('name')->label(__('Name'))->searchable()->sortable(),
                Tables\Columns\TextColumn::make('title')->label(__('Title'))->searchable()->limit(20),
                Tables\Columns\TextColumn::make('rating')->label(__('Rating'))->sortable(),
                Tables\Columns\IconColumn::make('is_visible')->label(__('Visible'))->boolean()->sortable(),
            ])
            ->filters([Tables\Filters\TernaryFilter::make('is_visible')])
            ->actions([Actions\EditAction::make()->slideOver()->modalWidth('xl'), Actions\DeleteAction::make()])
            ->bulkActions([Actions\BulkActionGroup::make([Actions\DeleteBulkAction::make()])])
            ->defaultSort('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTestimonials::route('/'),
            'create' => Pages\CreateTestimonial::route('/create'),
            'edit' => Pages\EditTestimonial::route('/{record}/edit'),
        ];
    }
}
