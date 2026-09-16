<?php

namespace App\Filament\Resources\BookingResource\RelationManagers;

use App\Models\BookingNote;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class NotesListRelationManager extends RelationManager
{
    protected static string $relationship = 'notes_list';

    public function isReadOnly(): bool
    {
        return false;
    }

    protected function canCreate(): bool
    {
        return true;
    }

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return 'سجل متابعات وملاحظات فريق المبيعات';
    }

    public static function getModelLabel(): string
    {
        return 'ملاحظة مبيعات';
    }

    public static function getPluralModelLabel(): string
    {
        return 'ملاحظات ومتابعات المبيعات';
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('type')
                    ->label('نوع المتابعة')
                    ->options([
                        'note' => '📝 ملاحظة عامة',
                        'call' => '📞 اتصال هاتفي',
                        'status_change' => '🔄 تحديث حالة',
                    ])
                    ->default('note')
                    ->required(),

                Textarea::make('note')
                    ->label('نص الملاحظة / تفاصيل التواصل')
                    ->placeholder('اكتب تفاصيل التواصل مع العميل أو ملخص المكالمة أو ملاحظاتك...')
                    ->required()
                    ->rows(4)
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('note')
            ->heading('سجل متابعات وملاحظات فريق المبيعات')
            ->description('جميع تعليقات ومكالمات وتحديثات فريق المبيعات على هذا الطلب')
            ->columns([
                TextColumn::make('created_at')
                    ->label('التاريخ والوقت')
                    ->dateTime('Y-m-d h:i A')
                    ->description(fn (BookingNote $record): ?string => $record->created_at?->diffForHumans())
                    ->sortable()
                    ->width('180px'),

                TextColumn::make('employee.name')
                    ->label('مسؤول المبيعات')
                    ->icon('heroicon-m-user')
                    ->weight('bold')
                    ->default('النظام / الإدارة')
                    ->searchable()
                    ->width('180px'),

                TextColumn::make('type')
                    ->label('نوع الإجراء')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'call' => '📞 اتصال هاتفي',
                        'status_change' => '🔄 تغيير حالة',
                        default => '📝 ملاحظة',
                    })
                    ->color(fn (?string $state): string => match ($state) {
                        'call' => 'info',
                        'status_change' => 'warning',
                        default => 'gray',
                    })
                    ->width('140px'),

                TextColumn::make('note')
                    ->label('تفاصيل الملاحظة / المتابعة')
                    ->wrap()
                    ->searchable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->headerActions([
                CreateAction::make()
                    ->label('إضافة ملاحظة جديدة')
                    ->icon('heroicon-o-plus-circle')
                    ->modalHeading('إضافة ملاحظة / متابعة جديدة')
                    ->modalIcon('heroicon-o-chat-bubble-left-ellipsis')
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['employee_id'] = Auth::guard('employee')->id();

                        return $data;
                    }),
            ])
            ->recordActions([
                EditAction::make()
                    ->visible(fn (BookingNote $record): bool => (bool) Auth::guard('employee')->user()?->isAdmin() || Auth::guard('employee')->id() === $record->employee_id),
                DeleteAction::make()
                    ->visible(fn (): bool => (bool) Auth::guard('employee')->user()?->isAdmin()),
            ]);
    }
}
