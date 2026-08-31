<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ActivityLogResource\Pages;
use App\Models\ActivityLog;
use App\Models\Employee;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ActivityLogResource extends Resource
{
    use \App\Traits\HasResourcePermission;

    protected static string|array|null $permission = 'manage-employees';

    protected static ?string $model = ActivityLog::class;

    protected static string|\BackedEnum|null $navigationIcon = null;

    public static function getNavigationGroup(): ?string
    {
        return 'الفريق';
    }

    protected static ?int $navigationSort = 3;

    public static function getModelLabel(): string
    {
        return 'سجل نشاط';
    }

    public static function getPluralModelLabel(): string
    {
        return 'السجلات';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('تفاصيل السجل')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('user_name')
                                    ->label('اسم المستخدم / الموظف')
                                    ->disabled(),
                                Forms\Components\TextInput::make('user_email')
                                    ->label('البريد الإلكتروني')
                                    ->disabled(),
                                Forms\Components\TextInput::make('action')
                                    ->label('نوع الإجراء')
                                    ->formatStateUsing(fn ($record) => $record?->action_label ?? '')
                                    ->disabled(),
                            ]),
                        Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('subject_type')
                                    ->label('القسم / العنصر')
                                    ->disabled(),
                                Forms\Components\TextInput::make('subject_title')
                                    ->label('بيان / عنوان العنصر')
                                    ->disabled(),
                                Forms\Components\TextInput::make('created_at')
                                    ->label('تاريخ وتوقيت العملية')
                                    ->formatStateUsing(fn ($state) => $state ? $state->format('Y-m-d H:i:s') : '')
                                    ->disabled(),
                            ]),
                        Forms\Components\Textarea::make('description')
                            ->label('وصف العملية')
                            ->rows(3)
                            ->disabled()
                            ->columnSpanFull(),
                        Forms\Components\KeyValue::make('properties.attributes')
                            ->label('البيانات المحفوظة / المحذوفة')
                            ->visible(fn ($record) => ! empty($record?->properties['attributes']))
                            ->disabled()
                            ->columnSpanFull(),
                        Forms\Components\KeyValue::make('properties.old')
                            ->label('البيانات السابقة قبل التعديل')
                            ->visible(fn ($record) => ! empty($record?->properties['old']))
                            ->disabled()
                            ->columnSpanFull(),
                        Forms\Components\KeyValue::make('properties.new')
                            ->label('البيانات الجديدة بعد التعديل')
                            ->visible(fn ($record) => ! empty($record?->properties['new']))
                            ->disabled()
                            ->columnSpanFull(),
                        Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('ip_address')
                                    ->label('عنوان IP')
                                    ->disabled(),
                                Forms\Components\TextInput::make('user_agent')
                                    ->label('المتصفح / الجهاز')
                                    ->disabled(),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user_name')
                    ->label('المستخدم / الموظف')
                    ->description(fn (ActivityLog $record): ?string => $record->user_email)
                    ->searchable(['user_name', 'user_email'])
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\BadgeColumn::make('action')
                    ->label('نوع الإجراء')
                    ->formatStateUsing(fn (ActivityLog $record): string => $record->action_label)
                    ->colors([
                        'success' => fn ($state): bool => in_array($state, ['created', 'completed']),
                        'info' => 'updated',
                        'danger' => 'deleted',
                        'warning' => 'status_changed',
                        'gray' => 'login',
                    ]),

                Tables\Columns\TextColumn::make('subject_type')
                    ->label('القسم')
                    ->badge()
                    ->color('primary')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('subject_title')
                    ->label('العنصر المعني')
                    ->searchable()
                    ->limit(40)
                    ->tooltip(fn (ActivityLog $record): ?string => $record->subject_title),

                Tables\Columns\TextColumn::make('description')
                    ->label('التفاصيل')
                    ->searchable()
                    ->limit(50)
                    ->tooltip(fn (ActivityLog $record): ?string => $record->description),

                Tables\Columns\TextColumn::make('ip_address')
                    ->label('IP')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('التاريخ والوقت')
                    ->dateTime('Y-m-d h:i A')
                    ->since()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('employee_id')
                    ->label('الموظف')
                    ->options(fn () => Employee::query()->pluck('name', 'id')->all())
                    ->searchable()
                    ->preload(),

                Tables\Filters\SelectFilter::make('action')
                    ->label('نوع الإجراء')
                    ->options([
                        'created' => 'إضافة / إنشاء',
                        'updated' => 'تعديل / تحديث',
                        'deleted' => 'حذف',
                        'completed' => 'إنجاز / إنهاء',
                        'status_changed' => 'تغيير حالة',
                        'login' => 'تسجيل دخول',
                    ]),

                Tables\Filters\SelectFilter::make('subject_type')
                    ->label('القسم')
                    ->options(fn () => ActivityLog::query()
                        ->whereNotNull('subject_type')
                        ->distinct()
                        ->pluck('subject_type', 'subject_type')
                        ->all()
                    ),

                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')->label('من تاريخ'),
                        Forms\Components\DatePicker::make('created_until')->label('إلى تاريخ'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Actions\ViewAction::make()
                    ->label('عرض التفاصيل')
                    ->modalHeading('تفاصيل سجل النشاط')
                    ->slideOver(),
            ])
            ->bulkActions([])
            ->defaultSort('created_at', 'desc');
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit($record): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListActivityLogs::route('/'),
        ];
    }
}
