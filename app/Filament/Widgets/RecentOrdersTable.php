<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Filament\Actions;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentOrdersTable extends BaseWidget
{
    protected static bool $isLazy = true;

    protected static ?int $sort = 7;

    public function getHeading(): ?string
    {
        return __('Recent Orders');
    }

    protected static ?string $heading = null;

    public int|string|array $columnSpan = [
        'xl' => 2,
        'lg' => 2,
        'md' => 2,
        'sm' => 1,
    ];

    public function table(Table $table): Table
    {
        $user = \Illuminate\Support\Facades\Auth::guard('employee')->user();
        $query = Booking::with(['car.brand', 'assignedTo'])->latest();

        if ($user && ! $user->isAdmin()) {
            $canCash = $user->hasPermission('manage-cash-bookings');
            $canFinance = $user->hasPermission('manage-finance-bookings');
            $canCorporate = $user->hasPermission('manage-corporate-bookings');
            $canAll = $user->hasPermission('manage-bookings');

            if (! $canAll) {
                $query->where(function ($q) use ($user, $canCash, $canFinance, $canCorporate) {
                    $q->where('assigned_to', $user->id);

                    if ($canCash) {
                        $q->orWhere(fn ($cq) => $cq->where('payment_method', 'cash')->whereNull('assigned_to'));
                    }
                    if ($canFinance) {
                        $q->orWhere(fn ($fq) => $fq->whereIn('payment_method', ['bank', 'finance', 'installment'])->whereNull('assigned_to'));
                    }
                    if ($canCorporate) {
                        $q->orWhere(fn ($corq) => $corq->where('booking_type', 'corporate')->whereNull('assigned_to'));
                    }
                });
            }
        }

        return $table
            ->query($query->limit(5))
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label(__('ID'))
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('client_name')
                    ->label(__('Client'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('car.name')
                    ->label(__('Car'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('total_price')
                    ->label(__('Price'))
                    ->money('SAR')
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'primary' => 'new',
                        'info' => 'contacted',
                        'warning' => 'interested',
                        'success' => 'sold',
                        'danger' => 'rejected',
                    ]),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Date'))
                    ->date()
                    ->sortable(),
            ])
            ->actions([
                Actions\Action::make('view')
                    ->icon('heroicon-m-eye')
                    ->url(fn (Booking $record): string => route('filament.admin.resources.bookings.view', $record)),
            ]);
    }
}
