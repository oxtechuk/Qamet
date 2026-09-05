<?php

namespace App\Filament\Resources\BookingResource\Pages;

use App\Filament\Resources\BookingResource;
use App\Models\Booking;
use App\Models\Employee;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Auth;

class ShowBooking extends ViewRecord
{
    protected static string $resource = BookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
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
                        ->options(fn () => Employee::query()->pluck('name', 'id')->toArray())
                        ->default(fn (Booking $record) => $record->assigned_to)
                        ->searchable()
                        ->preload()
                        ->required(),
                ])
                ->action(function (Booking $record, array $data) {
                    $record->update(['assigned_to' => $data['assigned_to']]);
                    $this->refreshFormData(['assigned_to']);
                }),

            Actions\Action::make('change_status')
                ->label(__('تغيير الحالة'))
                ->icon('heroicon-o-arrow-path')
                ->color('warning')
                ->modalHeading(fn (Booking $record) => "تغيير حالة الطلب #{$record->id} - {$record->client_name}")
                ->modalIcon('heroicon-o-arrow-path')
                ->modalWidth('lg')
                ->form([
                    Forms\Components\Select::make('status')
                        ->label(__('الحالة الجديدة'))
                        ->options(function () {
                            $isAdmin = (bool) Auth::guard('employee')->user()?->isAdmin();
                            if ($isAdmin) {
                                return [
                                    'new' => __('New'),
                                    'contacted' => __('Contacted'),
                                    'interested' => __('Interested'),
                                    'negotiation' => __('Negotiation'),
                                    'sold' => __('Sold'),
                                    'under_review' => 'طلب إغلاق / مراجعة الإدارة',
                                    'rejected' => __('Rejected'),
                                    'cancelled' => __('Cancelled'),
                                ];
                            }

                            return [
                                'new' => __('New'),
                                'contacted' => __('Contacted'),
                                'interested' => __('Interested'),
                                'negotiation' => __('Negotiation'),
                                'sold' => __('Sold'),
                                'under_review' => 'طلب إغلاق / مراجعة الإدارة',
                            ];
                        })
                        ->default(fn (Booking $record) => $record->status)
                        ->required(),
                    Forms\Components\Textarea::make('note')
                        ->label('الملاحظات / سبب تغيير الحالة')
                        ->placeholder('اكتب تفاصيل التواصل أو سبب تغيير الحالة...')
                        ->rows(4),
                ])
                ->action(function (Booking $record, array $data) {
                    $oldStatus = $record->status;
                    $newStatus = $data['status'];
                    $noteText = trim($data['note'] ?? '');
                    $user = Auth::guard('employee')->user();
                    $repName = $user?->name ?: 'الموظف';

                    $updateData = ['status' => $newStatus];

                    if (! empty($noteText)) {
                        $statusLabels = [
                            'new' => 'جديد',
                            'contacted' => 'تم التواصل',
                            'interested' => 'مهتم',
                            'negotiation' => 'تفاوض',
                            'sold' => 'تم البيع',
                            'under_review' => 'طلب إغلاق / مراجعة الإدارة',
                            'rejected' => 'مرفوض',
                            'cancelled' => 'ملغي',
                        ];
                        $oldLabel = $statusLabels[$oldStatus] ?? $oldStatus;
                        $newLabel = $statusLabels[$newStatus] ?? $newStatus;

                        $noteEntry = "\n[".now()->format('Y-m-d H:i')." - تغيير الحالة من ({$oldLabel}) إلى ({$newLabel}) بواسطة ({$repName}): {$noteText}]";
                        $updateData['notes'] = trim(($record->notes ?? '').$noteEntry);

                        \App\Models\BookingNote::create([
                            'booking_id' => $record->id,
                            'employee_id' => $user?->id,
                            'old_status' => $oldStatus,
                            'new_status' => $newStatus,
                            'note' => $noteText,
                            'type' => 'status_change',
                        ]);
                    }

                    $record->update($updateData);
                    $this->refreshFormData(['status', 'notes']);

                    \App\Services\ActivityLog\ActivityLogger::log(
                        action: 'status_changed',
                        subjectType: 'طلب حجز',
                        subjectId: $record->id,
                        subjectTitle: "طلب حجز #{$record->id} - {$record->client_name}",
                        description: "قام {$repName} بتغيير حالة الطلب إلى {$newStatus}".(! empty($noteText) ? " مع ملاحظة: {$noteText}" : '')
                    );

                    \Filament\Notifications\Notification::make()
                        ->title('تم تحديث حالة الطلب والملاحظة بنجاح')
                        ->success()
                        ->send();
                }),

            Actions\Action::make('order_notes')
                ->label('إضافة / تعديل الملاحظات')
                ->icon('heroicon-o-chat-bubble-bottom-center-text')
                ->color('gray')
                ->modalHeading(fn (Booking $record) => "ملاحظات الطلب #{$record->id} - {$record->client_name}")
                ->modalIcon('heroicon-o-chat-bubble-bottom-center-text')
                ->modalWidth('lg')
                ->form([
                    Forms\Components\Textarea::make('notes')
                        ->label('ملاحظات وسجل الطلب')
                        ->placeholder('اكتب ملاحظة جديدة أو عدل الملاحظات الحالية...')
                        ->rows(6)
                        ->default(fn (Booking $record) => $record->notes),
                ])
                ->action(function (Booking $record, array $data) {
                    $record->update(['notes' => $data['notes']]);
                    $this->refreshFormData(['notes']);
                    \Filament\Notifications\Notification::make()
                        ->title('تم حفظ الملاحظات بنجاح')
                        ->success()
                        ->send();
                }),

            Actions\Action::make('create_task')
                ->label(__('إضافة مهمة متابعة'))
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

            Actions\EditAction::make()
                ->visible(fn () => (bool) Auth::guard('employee')->user()?->isAdmin()),
            Actions\DeleteAction::make()
                ->visible(fn () => (bool) Auth::guard('employee')->user()?->isAdmin()),
        ];
    }
}
