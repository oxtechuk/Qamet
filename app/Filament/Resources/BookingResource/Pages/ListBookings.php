<?php

namespace App\Filament\Resources\BookingResource\Pages;

use App\Filament\Resources\BookingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

use App\Services\BookingAssignmentService;
use Filament\Forms;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class ListBookings extends ListRecords
{
    protected static string $resource = BookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('rebalance_all_bookings')
                ->label('إعادة التوزيع العادل للطلبات')
                ->icon('heroicon-o-arrow-path-rounded-square')
                ->color('warning')
                ->visible(fn () => (bool) (Auth::guard('employee')->user()?->isAdmin() || Auth::guard('employee')->user()?->hasPermission('manage-bookings')))
                ->modalHeading('إعادة التوزيع العادل والمتساوي للطلبات')
                ->modalDescription('سيقوم النظام بموازنة أعداد الطلبات وتوزيعها بالتساوي على المناديب المؤهلين وفقاً لتخصص كل مندوب (كاش / تقسيط / شركات) لمنع أي فوارق.')
                ->modalSubmitActionLabel('بدء التوزيع العادل الآن')
                ->form([
                    Forms\Components\Select::make('scope')
                        ->label('نطاق الطلبات المراد موازنتها')
                        ->options([
                            'open' => 'الطلبات النشطة وقيد المتابعة فقط (موصى به)',
                            'unassigned' => 'الطلبات غير المعينة فقط (بدون مندوب)',
                            'all' => 'كافة الطلبات المسجلة في النظام',
                        ])
                        ->default('open')
                        ->required(),
                    Forms\Components\Select::make('type')
                        ->label('نوع وتخصص الطلبات')
                        ->options([
                            'all' => 'كافة الأنواع (كاش وتقسيط وتمويل شركات)',
                            'cash' => 'طلبات الكاش فقط',
                            'finance' => 'طلبات التقسيط والتمويل فقط',
                            'corporate' => 'تمويل الشركات فقط',
                        ])
                        ->default('all')
                        ->required(),
                    Forms\Components\DatePicker::make('date_from')
                        ->label('من تاريخ (اختياري)'),
                    Forms\Components\DatePicker::make('date_until')
                        ->label('إلى تاريخ (اختياري)'),
                ])
                ->action(function (array $data, BookingAssignmentService $service) {
                    $result = $service->rebalanceAll($data);
                    $total = $result['total'];
                    $assigned = $result['assigned'];
                    $summary = $result['reps_summary'];

                    if ($total === 0) {
                        Notification::make()
                            ->title('لا توجد طلبات مطابقة للمعايير المحددة')
                            ->info()
                            ->send();

                        return;
                    }

                    $repsBreakdown = [];
                    foreach ($summary as $repName => $count) {
                        $repsBreakdown[] = "• {$repName}: {$count} طلب";
                    }

                    $bodyText = "تمت معالجة {$total} طلب، وتم تعيين {$assigned} طلب بالتساوي بين المناديب:\n".implode("\n", $repsBreakdown);

                    Notification::make()
                        ->title('تمت إعادة التوزيع العادل بنجاح')
                        ->body($bodyText)
                        ->success()
                        ->duration(10000)
                        ->send();
                }),
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        $baseQuery = $this->getTableQuery();

        return [
            'all' => Tab::make('كل الطلبات')
                ->badge((clone $baseQuery)->count()),

            'cash' => Tab::make('طلبات الكاش')
                ->icon('heroicon-m-banknotes')
                ->modifyQueryUsing(fn (Builder $query) => $query->cash())
                ->badge((clone $baseQuery)->cash()->count()),

            'finance' => Tab::make('طلبات التقسيط')
                ->icon('heroicon-m-credit-card')
                ->modifyQueryUsing(fn (Builder $query) => $query->finance())
                ->badge((clone $baseQuery)->finance()->count()),

            'corporate' => Tab::make('تمويل الشركات')
                ->icon('heroicon-m-building-office-2')
                ->modifyQueryUsing(fn (Builder $query) => $query->corporate())
                ->badge((clone $baseQuery)->corporate()->count()),

            'under_review' => Tab::make('طلبات المراجعة')
                ->icon('heroicon-m-exclamation-triangle')
                ->modifyQueryUsing(fn (Builder $query) => $query->underReview())
                ->badge((clone $baseQuery)->underReview()->count())
                ->badgeColor('danger'),

            'completed' => Tab::make('طلبات مكتملة')
                ->icon('heroicon-m-check-badge')
                ->modifyQueryUsing(fn (Builder $query) => $query->completed())
                ->badge((clone $baseQuery)->completed()->count()),

            'cancelled' => Tab::make('طلبات ملغية ومرفوضة')
                ->icon('heroicon-m-x-circle')
                ->modifyQueryUsing(fn (Builder $query) => $query->cancelled())
                ->badge((clone $baseQuery)->cancelled()->count()),
        ];
    }

    public function table(Table $table): Table
    {
        return parent::table($table)
            ->contentGrid([
                'default' => 1,
                'md' => 2,
                'xl' => 3,
            ]);
    }
}
