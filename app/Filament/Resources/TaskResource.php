<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaskResource\Pages;
use App\Models\Task;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static string|\BackedEnum|null $navigationIcon = null;

    public static function getNavigationGroup(): ?string
    {
        return 'الفريق';
    }

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?int $navigationSort = 3;

    public static function getModelLabel(): string
    {
        return __('Task');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Tasks');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label(__('Title'))
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('booking_id')
                            ->label(__('Linked Order / Booking'))
                            ->relationship('booking', 'id')
                            ->getOptionLabelFromRecordUsing(fn ($record) => "#{$record->id} - {$record->client_name} (".($record->car?->name ?? 'طلب').')')
                            ->searchable()
                            ->preload(),
                        Forms\Components\DatePicker::make('due_date')
                            ->label(__('Due Date / Follow-up Date'))
                            ->default(now()->today())
                            ->required(),
                        Forms\Components\Select::make('priority')
                            ->label(__('Priority'))
                            ->options([
                                'high' => __('High'),
                                'medium' => __('Medium'),
                                'low' => __('Low'),
                            ])
                            ->default('medium')
                            ->required(),
                        Forms\Components\Select::make('status')
                            ->label(__('Status'))
                            ->options([
                                'new' => __('New'),
                                'in_progress' => __('In Progress'),
                                'done' => __('Done'),
                            ])
                            ->default('new')
                            ->required(),
                        Forms\Components\Select::make('assigned_to')
                            ->label(__('Assigned To'))
                            ->relationship('assignedTo', 'name')
                            ->searchable()
                            ->preload(),
                        Forms\Components\Textarea::make('description')
                            ->label(__('Description'))
                            ->rows(3),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label(__('Title'))
                    ->searchable()
                    ->sortable()
                    ->limit(40),

                Tables\Columns\TextColumn::make('booking.client_name')
                    ->label(__('Linked Order'))
                    ->formatStateUsing(fn ($state, $record) => $record->booking ? "#{$record->booking_id} - {$state}" : '-')
                    ->searchable()
                    ->badge()
                    ->color('info'),

                Tables\Columns\BadgeColumn::make('priority')
                    ->label(__('Priority'))
                    ->colors([
                        'danger' => 'high',
                        'warning' => 'medium',
                        'success' => 'low',
                    ])
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('status')
                    ->label(__('Status'))
                    ->colors([
                        'primary' => 'new',
                        'warning' => 'in_progress',
                        'success' => 'done',
                    ]),

                Tables\Columns\TextColumn::make('assignedTo.name')
                    ->label(__('Assigned'))
                    ->badge()
                    ->sortable(),

                Tables\Columns\TextColumn::make('due_date')
                    ->label(__('Due Date'))
                    ->date()
                    ->sortable()
                    ->color(fn ($record) => $record->due_date && $record->due_date->isPast() && $record->status !== 'done' ? 'danger' : null),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('priority'),
                Tables\Filters\SelectFilter::make('status'),
                Tables\Filters\SelectFilter::make('assigned_to')
                    ->relationship('assignedTo', 'name'),
            ])
            ->actions([
                Actions\EditAction::make()->slideOver()->modalWidth('2xl'),
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                    Actions\BulkAction::make('markDone')
                        ->label(__('Mark as Done'))
                        ->icon('heroicon-m-check-circle')
                        ->color('success')
                        ->action(fn ($records) => $records->each->update(['status' => 'done'])),
                ]),
            ])
            ->defaultSort('due_date', 'asc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTasks::route('/'),
        ];
    }
}
