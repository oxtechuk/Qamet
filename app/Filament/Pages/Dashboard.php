<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\MonthlyRevenueChart;
use App\Filament\Widgets\QuickActionsWidget;
use App\Filament\Widgets\RecentCarsWidget;
use App\Filament\Widgets\RecentOrdersTable;
use App\Filament\Widgets\RecentPaymentsWidget;
use App\Filament\Widgets\SalesTrendChart;
use App\Filament\Widgets\StatsOverviewWidget;
use App\Filament\Widgets\TopBrandsChart;
use App\Filament\Widgets\TopCategoriesChart;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    public function getTitle(): string
    {
        return __('Dashboard');
    }

    public static function canAccess(): bool
    {
        $user = \Illuminate\Support\Facades\Auth::guard('employee')->user();

        return $user && ($user->isAdmin() || $user->hasPermission('manage-dashboard'));
    }

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-home';

    protected static ?int $navigationSort = 0;

    public function getWidgets(): array
    {
        return [
            StatsOverviewWidget::class,
            QuickActionsWidget::class,
            MonthlyRevenueChart::class,
            SalesTrendChart::class,
            TopBrandsChart::class,
            TopCategoriesChart::class,
            RecentOrdersTable::class,
            RecentCarsWidget::class,
            RecentPaymentsWidget::class,
        ];
    }
}
