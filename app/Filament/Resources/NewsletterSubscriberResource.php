<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsletterSubscriberResource\Pages;
use App\Models\NewsletterSubscriber;
use Filament\Actions;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class NewsletterSubscriberResource extends Resource
{
    use \App\Traits\HasResourcePermission;

    protected static string|array|null $permission = 'manage-newsletter';

    protected static ?string $model = NewsletterSubscriber::class;

    protected static string|\BackedEnum|null $navigationIcon = null;

    public static function getNavigationGroup(): ?string
    {
        return 'العملاء';
    }

    protected static ?string $recordTitleAttribute = 'email';

    protected static ?int $navigationSort = 3;

    public static function getModelLabel(): string
    {
        return __('Subscriber');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Subscribers');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('email')->label(__('Email'))->searchable()->sortable()->copyable(),
                Tables\Columns\IconColumn::make('is_active')->label(__('Active'))->boolean()->sortable(),
                Tables\Columns\TextColumn::make('subscribed_at')->label(__('Subscribed At'))->dateTime()->sortable(),
                Tables\Columns\TextColumn::make('unsubscribed_at')->label(__('Unsubscribed At'))->dateTime()->sortable()->toggleable(),
            ])
            ->filters([Tables\Filters\TernaryFilter::make('is_active')])
            ->actions([Actions\DeleteAction::make()])
            ->bulkActions([Actions\BulkActionGroup::make([Actions\DeleteBulkAction::make()])])
            ->defaultSort('subscribed_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNewsletterSubscribers::route('/'),
        ];
    }
}
