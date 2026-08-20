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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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

    public static function canDelete(Model $record): bool
    {
        return (bool) Auth::guard('employee')->user()?->isAdmin();
    }

    public static function canDeleteAny(): bool
    {
        return (bool) Auth::guard('employee')->user()?->isAdmin();
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = Auth::guard('employee')->user();

        if (! $user || $user->isAdmin()) {
            return $query;
        }

        // 1. If explicit sales_type is specified on employee, respect it
        if ($user->sales_type === 'cash') {
            return $query->where(function (Builder $q) use ($user) {
                $q->where('assigned_to', $user->id)
                    ->orWhere(function (Builder $cashQ) {
                        $cashQ->where('payment_method', 'cash')->whereNull('assigned_to');
                    });
            });
        }

        if ($user->sales_type === 'finance') {
            return $query->where(function (Builder $q) use ($user) {
                $q->where('assigned_to', $user->id)
                    ->orWhere(function (Builder $finQ) {
                        $finQ->where(function (Builder $mQ) {
                            $mQ->whereIn('payment_method', ['bank', 'finance', 'installment'])
                                ->orWhereNull('payment_method');
                        })->whereNull('assigned_to')
                            ->orWhere(function (Builder $corpQ) {
                                $corpQ->where('booking_type', 'corporate')->whereNull('assigned_to');
                            });
                    });
            });
        }

        // 2. Otherwise determine by Spatie permissions
        $canCash = $user->hasPermissionTo('manage-cash-bookings', 'employee');
        $canFinance = $user->hasPermissionTo('manage-finance-bookings', 'employee');
        $canCorporate = $user->hasPermissionTo('manage-corporate-bookings', 'employee');
        $canAll = $user->hasPermissionTo('manage-bookings', 'employee') || $user->sales_type === 'all';

        if ($canAll || ($canCash && $canFinance)) {
            return $query->where(function (Builder $q) use ($user) {
                $q->where('assigned_to', $user->id)
                    ->orWhereNull('assigned_to');
            });
        }

        return $query->where(function (Builder $q) use ($user, $canCash, $canFinance, $canCorporate) {
            $q->where('assigned_to', $user->id);

            if ($canCash) {
                $q->orWhere(function (Builder $cashQ) {
                    $cashQ->where('payment_method', 'cash')->whereNull('assigned_to');
                });
            }

            if ($canFinance) {
                $q->orWhere(function (Builder $finQ) {
                    $finQ->where(function (Builder $mQ) {
                        $mQ->whereIn('payment_method', ['bank', 'finance', 'installment'])
                            ->orWhereNull('payment_method');
                    })->whereNull('assigned_to');
                });
            }

            if ($canCorporate) {
                $q->orWhere(function (Builder $corpQ) {
                    $corpQ->where('booking_type', 'corporate')->whereNull('assigned_to');
                });
            }
        });
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
                                Grid::make(3)
                                    ->schema([
                                        Forms\Components\TextInput::make('client_name')->label(__('Client Name'))
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('company_name')->label(__('اسم المنشأة / الشركة'))
                                            ->placeholder('في حال كان الطلب لشركة/مؤسسة')
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('client_phone')->label(__('Client Phone'))
                                            ->tel()
                                            ->required()
                                            ->maxLength(20),
                                    ]),
                                Grid::make(3)
                                    ->schema([
                                        Forms\Components\TextInput::make('client_email')->label(__('Client Email'))
                                            ->email()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('age')->label(__('العمر'))
                                            ->numeric()
                                            ->minValue(18)
                                            ->maxValue(100),
                                        Forms\Components\Select::make('purchase_urgency')->label(__('توقيت الشراء'))
                                            ->options([
                                                'today' => 'اليوم',
                                                '3_days' => 'خلال 3 أيام',
                                                'week' => 'خلال أسبوع',
                                                'month' => 'خلال شهر',
                                                'later' => 'لاحقاً',
                                                'inquiry' => 'مجرد استفسار',
                                            ])
                                            ->searchable(),
                                    ]),
                                Grid::make(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('preferred_contact_date')->label(__('تاريخ التواصل المفضل'))
                                            ->placeholder('مثال: 2026-08-25 أو غداً صباحاً'),
                                        Forms\Components\TextInput::make('preferred_contact_time')->label(__('الوقت المفضل للتواصل'))
                                            ->placeholder('مثال: 10:00 صباحاً - 02:00 مساءً'),
                                    ]),
                            ]),

                        Section::make(__('بيانات السيارة والدفع'))
                            ->icon('heroicon-o-truck')
                            ->schema([
                                Grid::make(3)
                                    ->schema([
                                        Forms\Components\Select::make('car_id')->label(__('Car'))
                                            ->relationship('car', 'name')
                                            ->searchable()
                                            ->preload(),
                                        Forms\Components\TextInput::make('car_type')->label(__('الموديل / الفئة'))
                                            ->placeholder(__('e.g. Toyota Camry 2025')),
                                        Forms\Components\TextInput::make('car_count')->label(__('عدد السيارات المطلوبة'))
                                            ->numeric()
                                            ->default(1)
                                            ->minValue(1),
                                    ]),
                                Grid::make(2)
                                    ->schema([
                                        Forms\Components\Select::make('payment_method')->label(__('Payment Method'))
                                            ->options([
                                                'cash' => __('Cash'),
                                                'bank' => __('Bank Financing / Installment'),
                                            ])
                                            ->default('cash')
                                            ->reactive(),
                                        Forms\Components\TextInput::make('total_price')->label(__('Total Price'))
                                            ->numeric()
                                            ->prefix(__('SAR')),
                                    ]),
                            ]),

                        Section::make(__('بيانات العمل والتمويل (للتقسيط)'))
                            ->icon('heroicon-o-banknotes')
                            ->schema([
                                Grid::make(3)
                                    ->schema([
                                        Forms\Components\Select::make('work_sector')->label(__('جهة العمل'))
                                            ->options([
                                                'government' => 'حكومي',
                                                'private' => 'قطاع خاص',
                                                'military' => 'عسكري',
                                                'retired' => 'متقاعد',
                                                'other' => 'أخرى',
                                            ]),
                                        Forms\Components\TextInput::make('salary')->label(__('الراتب الشهري'))
                                            ->numeric()
                                            ->prefix(__('SAR')),
                                        Forms\Components\TextInput::make('service_duration')->label(__('مدة الخدمة'))
                                            ->placeholder('مثال: سنتين'),
                                    ]),
                                Grid::make(2)
                                    ->schema([
                                        Forms\Components\Toggle::make('has_downpayment')->label(__('هل توجد دفعة أولى؟'))
                                            ->reactive(),
                                        Forms\Components\TextInput::make('down_payment')->label(__('قيمة الدفعة الأولى'))
                                            ->numeric()
                                            ->prefix(__('SAR'))
                                            ->visible(fn ($get) => (bool) $get('has_downpayment') || $get('down_payment') > 0),
                                    ]),
                                Grid::make(2)
                                    ->schema([
                                        Forms\Components\Toggle::make('has_obligations')->label(__('هل توجد التزامات / أقساط حالية؟'))
                                            ->reactive(),
                                        Forms\Components\TextInput::make('monthly_obligations')->label(__('إجمالي الأقساط الحالية'))
                                            ->numeric()
                                            ->prefix(__('SAR'))
                                            ->visible(fn ($get) => (bool) $get('has_obligations') || $get('monthly_obligations') > 0),
                                    ]),
                                Grid::make(3)
                                    ->schema([
                                        Forms\Components\TextInput::make('monthly_installment')->label(__('Monthly Installment'))
                                            ->numeric()
                                            ->prefix(__('SAR')),
                                        Forms\Components\TextInput::make('duration_years')->label(__('Duration Years'))
                                            ->numeric()
                                            ->suffix(__('years')),
                                        Forms\Components\TextInput::make('interest_rate')->label(__('Interest Rate %'))
                                            ->numeric()
                                            ->suffix('%'),
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
                                    ->disabled(fn () => ! (Auth::guard('employee')->user()?->isAdmin()))
                                    ->helperText(fn () => ! (Auth::guard('employee')->user()?->isAdmin()) ? 'إسناد وتحويل الطلبات متاح لمدير النظام فقط' : null)
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
                    ->sortable(),

                Tables\Columns\TextColumn::make('client_phone')->label(__('Client Phone'))
                    ->searchable()
                    ->copyable()
                    ->icon('heroicon-m-phone'),

                Tables\Columns\TextColumn::make('car.name')
                    ->label(__('Car'))
                    ->searchable()
                    ->limit(25),

                Tables\Columns\TextColumn::make('car_type')
                    ->label(__('الموديل / الفئة'))
                    ->limit(25)
                    ->placeholder('-'),

                Tables\Columns\TextColumn::make('payment_method')
                    ->label(__('طريقة الدفع'))
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'cash' => '💵 كاش',
                        'bank', 'finance', 'installment' => '💳 تقسيط / تمويل',
                        default => $state ?? '-',
                    })
                    ->color(fn (?string $state): string => match ($state) {
                        'cash' => 'success',
                        'bank', 'finance', 'installment' => 'info',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('purchase_urgency')
                    ->label(__('توقيت الشراء'))
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'today' => 'اليوم',
                        '3_days' => 'خلال 3 أيام',
                        'week' => 'خلال أسبوع',
                        'month' => 'خلال شهر',
                        'later' => 'لاحقاً',
                        'inquiry' => 'استفسار',
                        default => $state ?? '-',
                    })
                    ->color(fn (?string $state): string => match ($state) {
                        'today', '3_days' => 'danger',
                        'week' => 'warning',
                        'month' => 'info',
                        default => 'gray',
                    })
                    ->toggleable(),

                Tables\Columns\TextColumn::make('salary')
                    ->label(__('الراتب'))
                    ->money('SAR')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('total_price')->label(__('Total Price'))
                    ->money('SAR')
                    ->sortable(),

                Tables\Columns\TextColumn::make('assignedTo.name')
                    ->label(__('مندوب المبيعات'))
                    ->placeholder('غير مسند')
                    ->badge()
                    ->color(fn ($record) => $record->assigned_to ? 'info' : 'gray')
                    ->sortable(),

                Tables\Columns\SelectColumn::make('status')
                    ->label(__('Status'))
                    ->options([
                        'new' => __('New'),
                        'contacted' => __('Contacted'),
                        'interested' => __('Interested'),
                        'negotiation' => __('Negotiation'),
                        'sold' => __('Sold'),
                        'rejected' => __('Rejected'),
                        'cancelled' => __('Cancelled'),
                    ])
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Date'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('payment_method')
                    ->label(__('طريقة الدفع'))
                    ->options([
                        'cash' => 'كاش',
                        'bank' => 'تقسيط / تمويل بنكي',
                    ]),
                Tables\Filters\SelectFilter::make('purchase_urgency')
                    ->label(__('توقيت الشراء'))
                    ->options([
                        'today' => 'اليوم',
                        '3_days' => 'خلال 3 أيام',
                        'week' => 'خلال أسبوع',
                        'month' => 'خلال شهر',
                        'later' => 'لاحقاً',
                        'inquiry' => 'مجرد استفسار',
                    ]),
                Tables\Filters\SelectFilter::make('work_sector')
                    ->label(__('جهة العمل'))
                    ->options([
                        'government' => 'حكومي',
                        'private' => 'قطاع خاص',
                        'military' => 'عسكري',
                        'retired' => 'متقاعد',
                        'other' => 'أخرى',
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'new' => __('New'),
                        'contacted' => __('Contacted'),
                        'interested' => __('Interested'),
                        'negotiation' => __('Negotiation'),
                        'sold' => __('Sold'),
                        'rejected' => __('Rejected'),
                    ]),
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
                                            $taskTitle = is_array($task->title) ? ($task->title['ar'] ?? $task->title['en'] ?? '-') : (string) ($task->title ?? '-');
                                            $priorityLabel = is_array($task->priority_label) ? ($task->priority_label['ar'] ?? $task->priority_label['en'] ?? '-') : (string) ($task->priority_label ?? '-');
                                            $statusLabel = is_array($task->status_label) ? ($task->status_label['ar'] ?? $task->status_label['en'] ?? '-') : (string) ($task->status_label ?? '-');
                                            $assignedName = is_array($task->assignedTo?->name) ? ($task->assignedTo->name['ar'] ?? $task->assignedTo->name['en'] ?? '-') : (string) ($task->assignedTo?->name ?? '-');
                                            $html .= '<tr class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800/50">';
                                            $html .= '<td class="p-3 border border-gray-200 dark:border-gray-700 font-semibold">'.htmlspecialchars($taskTitle).'</td>';
                                            $html .= '<td class="p-3 border border-gray-200 dark:border-gray-700 font-mono text-amber-600 dark:text-amber-400">'.($task->due_date ? $task->due_date->format('Y-m-d') : '-').'</td>';
                                            $html .= '<td class="p-3 border border-gray-200 dark:border-gray-700"><span class="px-2 py-1 text-xs font-bold rounded bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">'.htmlspecialchars($priorityLabel).'</span></td>';
                                            $html .= '<td class="p-3 border border-gray-200 dark:border-gray-700"><span class="px-2 py-1 text-xs font-bold rounded bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-200">'.htmlspecialchars($statusLabel).'</span></td>';
                                            $html .= '<td class="p-3 border border-gray-200 dark:border-gray-700 text-gray-500">'.htmlspecialchars($assignedName).'</td>';
                                            $html .= '</tr>';
                                        }
                                        $html .= '</tbody></table></div>';

                                        return new \Illuminate\Support\HtmlString($html);
                                    }),
                            ]),
                    ]),
                Actions\Action::make('assign_employee')
                    ->label(__('إسناد موظف'))
                    ->icon('heroicon-o-user-plus')
                    ->color('info')
                    ->visible(fn () => (bool) Auth::guard('employee')->user()?->isAdmin())
                    ->slideOver()
                    ->modalWidth('md')
                    ->form([
                        Forms\Components\Select::make('assigned_to')
                            ->label(__('الموظف المسند إليه'))
                            ->options(fn () => \App\Models\Employee::query()->pluck('name', 'id')->toArray())
                            ->searchable()
                            ->preload()
                            ->required(),
                    ])
                    ->action(function (Booking $record, array $data) {
                        $record->update(['assigned_to' => $data['assigned_to']]);
                    }),
                Actions\Action::make('change_status')
                    ->label(__('تغيير الحالة'))
                    ->icon('heroicon-o-arrow-path')
                    ->color('warning')
                    ->slideOver()
                    ->modalWidth('md')
                    ->form([
                        Forms\Components\Select::make('status')
                            ->label(__('الحالة'))
                            ->options([
                                'new' => __('New'),
                                'contacted' => __('Contacted'),
                                'interested' => __('Interested'),
                                'negotiation' => __('Negotiation'),
                                'sold' => __('Sold'),
                                'rejected' => __('Rejected'),
                                'cancelled' => __('Cancelled'),
                            ])
                            ->default(fn (Booking $record) => $record->status)
                            ->required(),
                    ])
                    ->action(function (Booking $record, array $data) {
                        $record->update(['status' => $data['status']]);
                    }),
                Actions\Action::make('create_task')
                    ->label(__('Follow-up Task'))
                    ->icon('heroicon-o-clipboard-document-check')
                    ->color('secondary')
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
                Actions\DeleteAction::make()
                    ->visible(fn () => (bool) Auth::guard('employee')->user()?->isAdmin()),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make()
                        ->visible(fn () => (bool) Auth::guard('employee')->user()?->isAdmin()),
                    Actions\BulkAction::make('bulk_assign')
                        ->label(__('إسناد المحددة لموظف'))
                        ->icon('heroicon-o-user-plus')
                        ->color('info')
                        ->visible(fn () => (bool) Auth::guard('employee')->user()?->isAdmin())
                        ->form([
                            Forms\Components\Select::make('assigned_to')
                                ->label(__('الموظف المسند إليه'))
                                ->options(fn () => \App\Models\Employee::query()->pluck('name', 'id')->toArray())
                                ->searchable()
                                ->preload()
                                ->required(),
                        ])
                        ->action(fn ($records, array $data) => $records->each->update(['assigned_to' => $data['assigned_to']])),
                    Actions\BulkAction::make('bulk_change_status')
                        ->label(__('تغيير حالة المحددة'))
                        ->icon('heroicon-o-arrow-path')
                        ->color('warning')
                        ->form([
                            Forms\Components\Select::make('status')
                                ->label(__('الحالة الجديده'))
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
                        ])
                        ->action(fn ($records, array $data) => $records->each->update(['status' => $data['status']])),
                    Actions\BulkAction::make('markAsSold')
                        ->label(__('Mark as Sold'))
                        ->icon('heroicon-m-check-circle')
                        ->color('success')
                        ->action(fn ($records) => $records->each->update(['status' => 'sold'])),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
