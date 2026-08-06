<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingResource\Pages;
use App\Models\Booking;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static string|\BackedEnum|null $navigationIcon = null;

    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): ?string
    {
        return 'الطلبات';
    }

    protected static ?string $recordTitleAttribute = 'client_name';

    public static function getModelLabel(): string
    {
        return __('Booking');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Bookings');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->schema([
                // Left/Main Column: Client Info & Car Pricing (2/3 Width)
                Grid::make(1)
                    ->columnSpan(2)
                    ->schema([
                        Section::make(__('Client Info'))
                            ->icon('heroicon-o-user')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('client_name')->label(__('Client Name'))
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('client_phone')->label(__('Client Phone'))
                                            ->tel()
                                            ->required()
                                            ->maxLength(20),
                                    ]),
                                Grid::make(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('client_email')->label(__('Client Email'))
                                            ->email()
                                            ->maxLength(255),
                                        Forms\Components\Select::make('booking_type')->label(__('Booking Type'))
                                            ->options([
                                                'test_drive' => __('Test Drive'),
                                                'booking' => __('Booking'),
                                                'loan' => __('Loan Request'),
                                            ])
                                            ->required(),
                                    ]),
                            ]),

                        Section::make(__('Car & Pricing'))
                            ->icon('heroicon-o-truck')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        Forms\Components\Select::make('car_id')->label(__('Car'))
                                            ->relationship('car', 'name')
                                            ->searchable()
                                            ->preload(),
                                        Forms\Components\TextInput::make('car_type')->label(__('Car Type'))
                                            ->placeholder(__('e.g. Toyota Camry 2025'))
                                            ->helperText(__('Required if no car is selected from inventory.')),
                                    ]),
                                Grid::make(3)
                                    ->schema([
                                        Forms\Components\TextInput::make('total_price')->label(__('Total Price'))
                                            ->numeric()
                                            ->prefix(__('SAR')),
                                        Forms\Components\TextInput::make('down_payment')->label(__('Down Payment'))
                                            ->numeric()
                                            ->prefix(__('SAR')),
                                        Forms\Components\TextInput::make('monthly_installment')->label(__('Monthly Installment'))
                                            ->numeric()
                                            ->prefix(__('SAR')),
                                    ]),
                                Grid::make(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('duration_years')->label(__('Duration Years'))
                                            ->numeric()
                                            ->suffix(__('years')),
                                        Forms\Components\Select::make('payment_method')->label(__('Payment Method'))
                                            ->options([
                                                'cash' => __('Cash'),
                                                'bank' => __('Bank Financing'),
                                            ]),
                                    ]),
                            ]),
                    ]),

                // Right/Side Column: Status & Assignment (1/3 Width)
                Grid::make(1)
                    ->columnSpan(1)
                    ->schema([
                        Section::make(__('Status & Assignment'))
                            ->icon('heroicon-o-flag')
                            ->schema([
                                Forms\Components\Select::make('status')->label(__('Status'))
                                    ->options([
                                        'new' => __('New'),
                                        'contacted' => __('Contacted'),
                                        'interested' => __('Interested'),
                                        'negotiation' => __('Negotiation'),
                                        'sold' => __('Sold'),
                                        'rejected' => __('Rejected'),
                                        'cancelled' => __('Cancelled'),
                                    ])
                                    ->required(),
                                Forms\Components\Select::make('assigned_to')->label(__('Assigned To'))
                                    ->relationship('assignedTo', 'name')
                                    ->searchable()
                                    ->preload(),
                                Forms\Components\Select::make('source')->label(__('Source'))
                                    ->options([
                                        'website' => __('Website'),
                                        'whatsapp' => __('WhatsApp'),
                                        'referral' => __('Referral'),
                                        'instagram' => __('Instagram'),
                                        'facebook' => __('Facebook'),
                                        'showroom' => __('Showroom'),
                                        'other' => __('Other'),
                                    ])
                                    ->searchable(),
                                Forms\Components\Textarea::make('notes')->label(__('Notes'))
                                    ->rows(4),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label(__('ID'))
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('client_name')->label(__('Client Name'))
                    ->searchable()
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('client_phone')->label(__('Client Phone'))
                    ->searchable()
                    ->copyable()
                    ->icon('heroicon-m-phone'),

                Tables\Columns\TextColumn::make('car.name')
                    ->label(__('Car'))
                    ->searchable()
                    ->limit(25),

                Tables\Columns\TextColumn::make('car_type')
                    ->label(__('Car Type'))
                    ->limit(25)
                    ->placeholder('-'),

                Tables\Columns\TextColumn::make('payment_method')
                    ->label(__('Payment'))
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'cash' => __('Cash'),
                        'bank' => __('Bank'),
                        default => '-',
                    })
                    ->color(fn (?string $state): string => match ($state) {
                        'cash' => 'success',
                        'bank' => 'info',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('total_price')->label(__('Total Price'))
                    ->money('SAR')
                    ->sortable(),

                Tables\Columns\TextColumn::make('assignedTo.name')
                    ->label(__('Assigned'))
                    ->badge()
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('status')->label(__('Status'))
                    ->colors([
                        'primary' => 'new',
                        'info' => 'contacted',
                        'warning' => fn ($state): bool => in_array($state, ['interested', 'negotiation'], true),
                        'success' => 'sold',
                        'danger' => 'rejected',
                        'gray' => 'cancelled',
                    ]),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Date'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'new' => __('New'),
                        'contacted' => __('Contacted'),
                        'interested' => __('Interested'),
                        'negotiation' => __('Negotiation'),
                        'sold' => __('Sold'),
                        'rejected' => __('Rejected'),
                    ]),
                Tables\Filters\SelectFilter::make('booking_type'),
                Tables\Filters\SelectFilter::make('assigned_to')
                    ->relationship('assignedTo', 'name')
                    ->searchable(),
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')->label(__('Created From')),
                        Forms\Components\DatePicker::make('created_until')->label(__('Created Until')),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['created_from'], fn ($q) => $q->whereDate('created_at', '>=', $data['created_from']))
                            ->when($data['created_until'], fn ($q) => $q->whereDate('created_at', '<=', $data['created_until']));
                    }),
            ])
            ->actions([
                Actions\ViewAction::make()
                    ->slideOver()
                    ->modalWidth('3xl')
                    ->form([
                        Section::make(__('Client & Order Details'))
                            ->schema([
                                Grid::make(3)->schema([
                                    Forms\Components\TextInput::make('client_name')->label(__('Client Name'))->disabled(),
                                    Forms\Components\TextInput::make('client_phone')->label(__('Client Phone'))->disabled(),
                                    Forms\Components\TextInput::make('client_email')->label(__('Client Email'))->disabled(),
                                ]),
                                Grid::make(3)->schema([
                                    Forms\Components\TextInput::make('car_type')->label(__('Car / Model'))->disabled(),
                                    Forms\Components\TextInput::make('booking_type')->label(__('Booking Type'))->disabled(),
                                    Forms\Components\TextInput::make('total_price')->label(__('Total Price'))->prefix('SAR')->disabled(),
                                ]),
                                Grid::make(2)->schema([
                                    Forms\Components\TextInput::make('status')->label(__('Status'))->disabled(),
                                    Forms\Components\TextInput::make('assignedTo.name')->label(__('Assigned To'))->disabled(),
                                ]),
                                Forms\Components\Textarea::make('notes')->label(__('Notes'))->disabled(),
                            ]),
                        Section::make(__('Linked Follow-up Tasks'))
                            ->icon('heroicon-o-clipboard-document-check')
                            ->schema([
                                Forms\Components\Placeholder::make('tasks_list')
                                    ->label('')
                                    ->content(function (Booking $record) {
                                        $tasks = $record->tasks()->with('assignedTo')->get();
                                        if ($tasks->isEmpty()) {
                                            return new \Illuminate\Support\HtmlString('<div class="p-4 text-center text-gray-500 bg-gray-50 dark:bg-gray-800 rounded-lg">'.__('No tasks created for this booking yet.').'</div>');
                                        }
                                        $html = '<div class="overflow-x-auto"><table class="w-full text-sm text-right border-collapse border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">';
                                        $html .= '<thead class="bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-200"><tr>';
                                        $html .= '<th class="p-3 border border-gray-200 dark:border-gray-700">'.__('Title').'</th>';
                                        $html .= '<th class="p-3 border border-gray-200 dark:border-gray-700">'.__('Due Date').'</th>';
                                        $html .= '<th class="p-3 border border-gray-200 dark:border-gray-700">'.__('Priority').'</th>';
                                        $html .= '<th class="p-3 border border-gray-200 dark:border-gray-700">'.__('Status').'</th>';
                                        $html .= '<th class="p-3 border border-gray-200 dark:border-gray-700">'.__('Assigned To').'</th>';
                                        $html .= '</tr></thead><tbody>';
                                        foreach ($tasks as $task) {
                                            $html .= '<tr class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800/50">';
                                            $html .= '<td class="p-3 border border-gray-200 dark:border-gray-700 font-semibold">'.htmlspecialchars($task->title).'</td>';
                                            $html .= '<td class="p-3 border border-gray-200 dark:border-gray-700 font-mono text-amber-600 dark:text-amber-400">'.($task->due_date ? $task->due_date->format('Y-m-d') : '-').'</td>';
                                            $html .= '<td class="p-3 border border-gray-200 dark:border-gray-700"><span class="px-2 py-1 text-xs font-bold rounded bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">'.htmlspecialchars($task->priority_label).'</span></td>';
                                            $html .= '<td class="p-3 border border-gray-200 dark:border-gray-700"><span class="px-2 py-1 text-xs font-bold rounded bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-200">'.htmlspecialchars($task->status_label).'</span></td>';
                                            $html .= '<td class="p-3 border border-gray-200 dark:border-gray-700 text-gray-500">'.htmlspecialchars($task->assignedTo?->name ?? '-').'</td>';
                                            $html .= '</tr>';
                                        }
                                        $html .= '</tbody></table></div>';

                                        return new \Illuminate\Support\HtmlString($html);
                                    }),
                            ]),
                    ]),
                Actions\Action::make('create_task')
                    ->label(__('Follow-up Task'))
                    ->icon('heroicon-o-clipboard-document-check')
                    ->color('warning')
                    ->slideOver()
                    ->modalWidth('xl')
                    ->form([
                        Forms\Components\TextInput::make('title')
                            ->label(__('Task Title'))
                            ->default(fn (Booking $record) => "متابعة طلب حجز #{$record->id} - {$record->client_name}")
                            ->required(),
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
                            ->default(fn (Booking $record) => $record->assigned_to)
                            ->searchable()
                            ->preload(),
                        Forms\Components\Textarea::make('description')
                            ->label(__('Description'))
                            ->rows(3),
                    ])
                    ->action(function (Booking $record, array $data) {
                        \App\Models\Task::create([
                            'booking_id' => $record->id,
                            'title' => $data['title'],
                            'due_date' => $data['due_date'],
                            'priority' => $data['priority'],
                            'status' => $data['status'],
                            'assigned_to' => $data['assigned_to'] ?? null,
                            'description' => $data['description'] ?? null,
                        ]);
                    }),
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                    Actions\BulkAction::make('markAsSold')
                        ->label(__('Mark as Sold'))
                        ->icon('heroicon-m-check-circle')
                        ->color('success')
                        ->action(fn ($records) => $records->each->update(['status' => 'sold'])),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->contentGrid([
                'default' => 1,
                'md' => 2,
                'xl' => 3,
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBookings::route('/'),
            'create' => Pages\CreateBooking::route('/create'),
            'view' => Pages\ShowBooking::route('/{record}'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }
}
