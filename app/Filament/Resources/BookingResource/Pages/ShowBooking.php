<?php

namespace App\Filament\Resources\BookingResource\Pages;

use App\Filament\Resources\BookingResource;
use App\Models\Booking;
use App\Models\Employee;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Pages\ViewRecord;

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
                    $this->refreshFormData(['status']);
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

            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
