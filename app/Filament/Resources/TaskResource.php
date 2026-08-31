<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaskResource\Pages;
use App\Models\Task;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class TaskResource extends Resource
{
    use \App\Traits\HasResourcePermission;

    protected static string|array|null $permission = 'manage-tasks';

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
            ->columns(1)
            ->schema([
                Section::make()
                    ->columnSpanFull()
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label(__('Title'))
                            ->required()
                            ->maxLength(255),
                        Grid::make(2)
                            ->schema([
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
                            ]),
                        Grid::make(3)
                            ->schema([
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
                            ]),
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

                Tables\Columns\TextColumn::make('priority')
                    ->label(__('Priority'))
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'high' => __('High'),
                        'medium' => __('Medium'),
                        'low' => __('Low'),
                        default => $state ?? '-',
                    })
                    ->color(fn (?string $state): string => match ($state) {
                        'high' => 'danger',
                        'medium' => 'warning',
                        'low' => 'success',
                        default => 'gray',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label(__('Status'))
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'new' => __('New'),
                        'in_progress' => __('In Progress'),
                        'done' => __('Done'),
                        default => $state ?? '-',
                    })
                    ->color(fn (?string $state): string => match ($state) {
                        'new' => 'primary',
                        'in_progress' => 'warning',
                        'done' => 'success',
                        default => 'gray',
                    }),

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
                Tables\Filters\SelectFilter::make('priority')
                    ->label(__('Priority'))
                    ->options([
                        'high' => __('High'),
                        'medium' => __('Medium'),
                        'low' => __('Low'),
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->label(__('Status'))
                    ->options([
                        'new' => __('New'),
                        'in_progress' => __('In Progress'),
                        'done' => __('Done'),
                    ]),
                Tables\Filters\SelectFilter::make('assigned_to')
                    ->label(__('Assigned To'))
                    ->relationship('assignedTo', 'name'),
            ])
            ->actions([
                Actions\EditAction::make()->slideOver()->modalWidth('2xl'),
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                    Actions\Action::make('markDone')
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
