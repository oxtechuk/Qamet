<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogPostResource\Pages;
use App\Models\BlogPost;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class BlogPostResource extends Resource
{
    protected static ?string $model = BlogPost::class;

    protected static string|\BackedEnum|null $navigationIcon = null;

    public static function getNavigationGroup(): ?string
    {
        return 'المحتوى';
    }

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?int $navigationSort = 1;

    public static function getModelLabel(): string
    {
        return __('Post');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Posts');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Tabs::make(__('Blog Post'))
                    ->tabs([
                        Tab::make(__('Content'))
                            ->schema([
                                Forms\Components\TextInput::make('title_ar')->label(__('Title').' ('.__('Arabic').')')->required()->maxLength(255),
                                Forms\Components\TextInput::make('title_en')->label(__('Title').' ('.__('English').')')->required()->maxLength(255),
                                Forms\Components\TextInput::make('slug')->label(__('Slug'))->placeholder(__('Auto-generated if left empty'))->maxLength(255)->unique(ignoreRecord: true),
                                Forms\Components\RichEditor::make('content_ar')->label(__('Content').' ('.__('Arabic').')')->required()->columnSpanFull(),
                                Forms\Components\RichEditor::make('content_en')->label(__('Content').' ('.__('English').')')->required()->columnSpanFull(),
                                Forms\Components\Textarea::make('excerpt_ar')->label(__('Excerpt').' ('.__('Arabic').')')->columnSpanFull(),
                                Forms\Components\Textarea::make('excerpt_en')->label(__('Excerpt').' ('.__('English').')')->columnSpanFull(),
                            ]),
                        Tab::make(__('Meta'))
                            ->schema([
                                Forms\Components\FileUpload::make('thumbnail')->label(__('Featured Image'))->image()->disk('public')->directory('blog')->visibility('public'),
                                Forms\Components\Select::make('categories')->label(__('Categories'))
                                    ->relationship('categories', 'name')
                                    ->multiple()
                                    ->preload(),
                                Grid::make(3)->schema([
                                    Forms\Components\Select::make('employee_id')->label(__('Author'))
                                        ->relationship('employee', 'name')
                                        ->searchable()
                                        ->preload(),
                                    Forms\Components\Toggle::make('is_published')->label(__('Published')),
                                    Forms\Components\Toggle::make('is_featured')->label(__('Featured')),
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
                Tables\Columns\TextColumn::make('title')->label(__('Title'))->searchable()->sortable()->limit(40),
                Tables\Columns\TextColumn::make('categories.name')->label(__('Categories'))->badge()->sortable(),
                Tables\Columns\TextColumn::make('employee.name')->label(__('Author'))->badge()->sortable(),
                Tables\Columns\IconColumn::make('is_published')->label(__('Published'))->boolean()->sortable(),
                Tables\Columns\IconColumn::make('is_featured')->label(__('Featured'))->boolean()->sortable(),
                Tables\Columns\TextColumn::make('created_at')->label(__('Created At'))->date()->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('categories')->relationship('categories', 'name')->multiple(),
                Tables\Filters\TernaryFilter::make('is_published'),
            ])
            ->actions([Actions\EditAction::make(), Actions\DeleteAction::make()])
            ->bulkActions([Actions\BulkActionGroup::make([Actions\DeleteBulkAction::make()])])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBlogPosts::route('/'),
            'create' => Pages\CreateBlogPost::route('/create'),
            'edit' => Pages\EditBlogPost::route('/{record}/edit'),
        ];
    }
}
