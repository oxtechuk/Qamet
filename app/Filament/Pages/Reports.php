<?php

namespace App\Filament\Pages;

use App\Models\Booking;
use App\Models\Employee;
use App\Models\Lead;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;

class Reports extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-chart-pie';

    public function getTitle(): string
    {
        return __('Reports & Analytics');
    }

    public static function getNavigationLabel(): string
    {
        return __('Reports & Analytics');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Settings');
    }

    protected static ?int $navigationSort = 2;

    protected string $view = 'filament.pages.reports';

    public ?array $filters = [
        'date_from' => null,
        'date_to' => null,
    ];

    public function getFinancialStats(): array
    {
        $query = Booking::query();
        if ($this->filters['date_from']) {
            $query->whereDate('created_at', '>=', $this->filters['date_from']);
        }
        if ($this->filters['date_to']) {
            $query->whereDate('created_at', '<=', $this->filters['date_to']);
        }

        return [
            'total_bookings' => (clone $query)->count(),
            'sold_count' => (clone $query)->where('status', 'sold')->count(),
            'total_revenue' => (clone $query)->where('status', 'sold')->sum('total_price'),
            'total_down_payments' => (clone $query)->whereNotNull('down_payment')->sum('down_payment'),
            'avg_down_payment' => (clone $query)->whereNotNull('down_payment')->avg('down_payment'),
            'avg_monthly' => (clone $query)->whereNotNull('monthly_installment')->avg('monthly_installment'),
            'avg_duration' => (clone $query)->whereNotNull('duration_years')->avg('duration_years'),
        ];
    }

    public function getTopCars(): array
    {
        return Booking::select('car_id', DB::raw('COUNT(*) as total'))
            ->where('status', 'sold')
            ->groupBy('car_id')
            ->orderByDesc('total')
            ->limit(5)
            ->with('car.brand')
            ->get()
            ->toArray();
    }

    public function getEmployeePerformance(): array
    {
        return Employee::withCount(['bookings as total_bookings'])
            ->withCount(['bookings as sold_bookings' => function ($q) {
                $q->where('status', 'sold');
            }])
            ->get()
            ->toArray();
    }

    public function getSourcePerformance(): array
    {
        return Lead::select('contact_source_id', DB::raw('COUNT(*) as total_leads'))
            ->groupBy('contact_source_id')
            ->with('contactSource')
            ->get()
            ->toArray();
    }

    public function updatedFilters(): void
    {
        $this->dispatch('$refresh');
    }
}
