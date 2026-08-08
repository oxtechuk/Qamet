<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use App\Models\Car;
use App\Models\Employee;
use App\Models\Lead;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected int|array|null $columns = [
        'default' => 2,
        'md' => 4,
        'lg' => 4,
    ];

    protected function getStats(): array
    {
        return \Illuminate\Support\Facades\Cache::remember('dashboard_stats_overview', 60, function () {
            $soldRevenue = Booking::where('status', 'sold');
            $monthlyRevenue = (clone $soldRevenue)->whereYear('created_at', now()->year)->whereMonth('created_at', now()->month)->sum('total_price');
            $totalRevenue = (clone $soldRevenue)->sum('total_price');
            $monthlyCount = (clone $soldRevenue)->whereYear('created_at', now()->year)->whereMonth('created_at', now()->month)->count();

            return [
                Stat::make(__('Total Inventory'), Car::count())
                    ->description(__('All cars in stock'))
                    ->descriptionIcon('heroicon-m-truck')
                    ->color('primary')
                    ->chart([7, 3, 10, 5, 15, 12, 18]),

                Stat::make(__('Available'), Car::where('availability_status', 'available')->count())
                    ->description(__('Ready for test drive & sale'))
                    ->descriptionIcon('heroicon-m-check-circle')
                    ->color('success'),

                Stat::make(__('Reserved / Sold'), Car::whereIn('availability_status', ['reserved', 'sold'])->count())
                    ->description(__('Under offer or completed'))
                    ->descriptionIcon('heroicon-m-clock')
                    ->color('warning'),

                Stat::make(__('Sold This Month'), $monthlyCount)
                    ->description(__('Units delivered'))
                    ->descriptionIcon('heroicon-m-currency-dollar')
                    ->color('info'),

                Stat::make(__('Revenue'), number_format($totalRevenue, 0).' '.__('SAR'))
                    ->description(__('All-time total'))
                    ->descriptionIcon('heroicon-m-banknotes')
                    ->color('success')
                    ->chart([20, 35, 28, 42, 38, 55, 48]),

                Stat::make(__('Monthly Revenue'), number_format($monthlyRevenue, 0).' '.__('SAR'))
                    ->description(__('Current month'))
                    ->descriptionIcon('heroicon-m-arrow-trending-up')
                    ->color('info'),

                Stat::make(__('Active Leads'), Lead::whereIn('status', ['new', 'contacted', 'interested', 'negotiation'])->count())
                    ->description(__('In sales pipeline'))
                    ->descriptionIcon('heroicon-m-users')
                    ->color('primary'),

                Stat::make(__('Active Team'), Employee::where('is_active', true)->count())
                    ->description(__('Sales & Support staff'))
                    ->descriptionIcon('heroicon-m-user-group')
                    ->color('secondary'),
            ];
        });
    }
}
