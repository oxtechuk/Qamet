<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReviewBookingResource\Pages;
use App\Models\Booking;
use App\Models\Employee;
use App\Services\ActivityLog\ActivityLogger;
use Filament\Actions;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ReviewBookingResource extends Resource
{
    use \App\Traits\HasResourcePermission;

    protected static ?string $model = Booking::class;

    protected static string|\BackedEnum|null $navigationIcon = null;

    protected static ?int $navigationSort = 2;

    public static function getNavigationGroup(): ?string
    {
        return 'الطلبات';
    }

    public static function getModelLabel(): string
    {
        return 'طلب مراجعة';
    }

    public static function getPluralModelLabel(): string
    {
        return 'طلبات المراجعة';
    }

    public static function getNavigationBadge(): ?string
    {
        $count = Booking::query()->where('status', 'under_review')->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    public static function canViewAny(): bool
    {
        $user = Auth::guard('employee')->user();

        return (bool) ($user?->isAdmin() || $user?->hasPermission('manage-bookings'));
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return (bool) Auth::guard('employee')->user()?->isAdmin();
    }

    public static function canDelete(Model $record): bool
    {
        return (bool) Auth::guard('employee')->user()?->isAdmin();
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereIn('status', ['under_review', 'closed', 'rejected']);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label(__('ID'))
                    ->sortable()
                    ->width('60px'),

                Tables\Columns\TextColumn::make('client_name')
                    ->label(__('العميل'))
                    ->description(fn (Booking $record): string => $record->client_phone)
                    ->searchable(['client_name', 'client_phone'])
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('car_info')
                    ->label(__('السيارة'))
                    ->getStateUsing(fn (Booking $record): string => implode(' ', array_filter([
                        $record->car?->name,
                        $record->car_type,
                    ])) ?: 'غير محدد')
                    ->limit(30)
                    ->searchable(['car_type']),

                Tables\Columns\TextColumn::make('payment_method')
                    ->label(__('الدفع'))
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'cash' => 'كاش',
                        'bank', 'finance', 'installment' => 'تقسيط',
                        default => $state ?: '-',
                    })
                    ->color(fn (?string $state): string => match ($state) {
                        'cash' => 'success',
                        'bank', 'finance', 'installment' => 'info',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('assignedTo.name')
                    ->label(__('المندوب'))
                    ->badge()
                    ->color('warning'),

                Tables\Columns\TextColumn::make('notes')
                    ->label(__('الملاحظات'))
                    ->limit(40)
                    ->tooltip(fn (Booking $record): ?string => $record->notes),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('تاريخ المراجعة'))
                    ->since()
                    ->description(fn (Booking $record): string => match ($record->status) {
                        'under_review' => '🟡 قيد المراجعة',
                        'closed' => '🔴 مقفول',
                        'rejected' => '⚫ مرفوض',
                        default => $record->status,
                    })
                    ->sortable(),
            ])
            ->actions([
                // 1. تأكيد الرفض / الإغلاق من الإدارة
                Actions\Action::make('confirm_rejection')
                    ->label('تأكيد الرفض والإغلاق')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('تأكيد رفض وإغلاق الطلب')
                    ->modalDescription('سيتم تأكيد رفض الطلب وإلغاء إسناده للمندوب ونقله للطلبات المرفوضة/الملغية.')
                    ->form([
                        Forms\Components\Textarea::make('admin_note')
                            ->label('ملاحظات الإدارة الإضافية (اختياري)')
                            ->placeholder('سبب اعتماد الإغلاق أو تعليق الإدارة...'),
                    ])
                    ->action(function (Booking $record, array $data) {
                        $oldAssignedRep = $record->assignedTo;
                        $noteText = ! empty($data['admin_note']) ? ' | ملاحظة الإدارة: '.$data['admin_note'] : '';

                        $record->update([
                            'status' => 'rejected',
                            'assigned_to' => null,
                            'notes' => trim(($record->notes ?? '').' [تم تأكيد الرفض من الإدارة'.$noteText.']'),
                        ]);

                        ActivityLogger::log(
                            action: 'completed',
                            subjectType: 'طلب حجز',
                            subjectId: $record->id,
                            subjectTitle: "طلب حجز #{$record->id} - {$record->client_name}",
                            description: "قام الإداري بتأكيد رفض وإغلاق الطلب رقم #{$record->id}"
                        );

                        Notification::make()
                            ->title('تم تأكيد رفض وإغلاق الطلب بنجاح')
                            ->success()
                            ->send();
                    }),

                // 2. إعادة الطلب للمندوب لمواصلة المتابعة
                Actions\Action::make('return_to_rep')
                    ->label('إعادة للمندوب')
                    ->icon('heroicon-o-arrow-uturn-left')
                    ->color('warning')
                    ->modalHeading('إعادة الطلب للمندوب لمواصلة المتابعة')
                    ->modalDescription('سيتم إعادة حالة الطلب إلى (تم التواصل) لكي يستمر المندوب في متابعة العميل.')
                    ->form([
                        Forms\Components\Textarea::make('admin_instructions')
                            ->label('توجيهات وملاحظات الإدارة للمندوب')
                            ->placeholder('مثال: تواصل مع العميل مرة أخرى واعرض عليه حلول التمويل البديلة...')
                            ->required(),
                    ])
                    ->action(function (Booking $record, array $data) {
                        $instruction = $data['admin_instructions'];

                        $record->update([
                            'status' => 'contacted',
                            'notes' => trim(($record->notes ?? '').' [توجيه الإدارة للمندوب: '.$instruction.']'),
                        ]);

                        if ($record->assignedTo) {
                            $record->assignedTo->notify(new \App\Notifications\NewBookingNotification(
                                $record,
                                'إعادة طلب حجز للمتابعة',
                                "تمت إعادة الطلب #{$record->id} للعميل {$record->client_name} لمواصلة المتابعة: {$instruction}"
                            ));
                        }

                        ActivityLogger::log(
                            action: 'updated',
                            subjectType: 'طلب حجز',
                            subjectId: $record->id,
                            subjectTitle: "طلب حجز #{$record->id} - {$record->client_name}",
                            description: "أعادت الإدارة الطلب #{$record->id} للمندوب مع التوجيه: {$instruction}"
                        );

                        Notification::make()
                            ->title('تمت إعادة الطلب للمندوب بنجاح')
                            ->success()
                            ->send();
                    }),

                // 3. تحويل لمندوب آخر
                Actions\Action::make('reassign_rep')
                    ->label('تحويل لمندوب آخر')
                    ->icon('heroicon-o-user-plus')
                    ->color('info')
                    ->form([
                        Forms\Components\Select::make('new_rep_id')
                            ->label('المندوب الجديد')
                            ->options(fn () => Employee::query()->where('is_active', true)->pluck('name', 'id')->toArray())
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\Textarea::make('reassign_note')
                            ->label('ملاحظة التحويل')
                            ->placeholder('سبب تحويل الطلب لمندوب آخر...'),
                    ])
                    ->action(function (Booking $record, array $data) {
                        $newRep = Employee::find($data['new_rep_id']);
                        $note = ! empty($data['reassign_note']) ? ' | سبب التحويل: '.$data['reassign_note'] : '';

                        $record->update([
                            'status' => 'new',
                            'assigned_to' => $newRep?->id,
                            'notes' => trim(($record->notes ?? '').' [تم تحويل الطلب من الإدارة إلى '.$newRep?->name.$note.']'),
                        ]);

                        if ($newRep) {
                            $newRep->notify(new \App\Notifications\NewBookingNotification(
                                $record,
                                'طلب محول جديد',
                                "تم تحويل طلب العميل {$record->client_name} إليك للمتابعة"
                            ));
                        }

                        ActivityLogger::log(
                            action: 'updated',
                            subjectType: 'طلب حجز',
                            subjectId: $record->id,
                            subjectTitle: "طلب حجز #{$record->id} - {$record->client_name}",
                            description: "قامت الإدارة بتحويل الطلب #{$record->id} إلى المندوب: {$newRep?->name}"
                        );

                        Notification::make()
                            ->title('تم تحويل الطلب بنجاح')
                            ->success()
                            ->send();
                    }),

                Actions\ViewAction::make()
                    ->label('عرض التفاصيل'),
            ])
            ->defaultSort('updated_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReviewBookings::route('/'),
        ];
    }
}
