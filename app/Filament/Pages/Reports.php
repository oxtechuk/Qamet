<?php

namespace App\Filament\Pages;

use App\Models\Booking;
use App\Models\Car;
use App\Models\Employee;
use App\Models\Lead;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;

class Reports extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = null;

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
        return 'الإعدادات والتحليلات';
    }

    protected static ?int $navigationSort = 1;

    protected string $view = 'filament.pages.reports';

    public string $activeTab = 'overview';

    public ?array $filters = [
        'date_from' => null,
        'date_to' => null,
        'employee_id' => null,
        'car_id' => null,
    ];

    public function mount(): void
    {
        // Default date range: current month
        $this->filters['date_from'] = now()->startOfMonth()->toDateString();
        $this->filters['date_to'] = now()->endOfMonth()->toDateString();
    }

    protected function applyFilters($query)
    {
        if ($this->filters['date_from']) {
            $query->whereDate('created_at', '>=', $this->filters['date_from']);
        }
        if ($this->filters['date_to']) {
            $query->whereDate('created_at', '<=', $this->filters['date_to']);
        }
        if ($this->filters['employee_id']) {
            $query->where('assigned_to', $this->filters['employee_id']);
        }
        if ($this->filters['car_id']) {
            $query->where('car_id', $this->filters['car_id']);
        }

        return $query;
    }

    public function getFinancialStats(): array
    {
        $query = Booking::query();
        $query = $this->applyFilters($query);

        return [
            'total_bookings' => (clone $query)->count(),
            'sold_count' => (clone $query)->where('status', 'sold')->count(),
            'total_revenue' => (clone $query)->where('status', 'sold')->sum('total_price'),
            'total_down_payments' => (clone $query)->whereNotNull('down_payment')->sum('down_payment'),
            'avg_down_payment' => (clone $query)->whereNotNull('down_payment')->avg('down_payment') ?? 0,
            'avg_monthly' => (clone $query)->whereNotNull('monthly_installment')->avg('monthly_installment') ?? 0,
            'avg_duration' => (clone $query)->whereNotNull('duration_years')->avg('duration_years') ?? 0,
        ];
    }

    public function getTopCars(): array
    {
        $query = Booking::query()
            ->select('car_id', DB::raw('COUNT(*) as total'))
            ->where('status', 'sold')
            ->groupBy('car_id')
            ->orderByDesc('total')
            ->limit(8)
            ->with('car.brand');

        $query = $this->applyFilters($query);

        return $query->get()->toArray();
    }

    public function getEmployeePerformance(): array
    {
        $query = Employee::query();

        $query->withCount(['bookings as total_bookings' => function ($q) {
            if ($this->filters['date_from']) {
                $q->whereDate('created_at', '>=', $this->filters['date_from']);
            }
            if ($this->filters['date_to']) {
                $q->whereDate('created_at', '<=', $this->filters['date_to']);
            }
            if ($this->filters['car_id']) {
                $q->where('car_id', $this->filters['car_id']);
            }
        }])
            ->withCount(['bookings as sold_bookings' => function ($q) {
                $q->where('status', 'sold');
                if ($this->filters['date_from']) {
                    $q->whereDate('created_at', '>=', $this->filters['date_from']);
                }
                if ($this->filters['date_to']) {
                    $q->whereDate('created_at', '<=', $this->filters['date_to']);
                }
                if ($this->filters['car_id']) {
                    $q->where('car_id', $this->filters['car_id']);
                }
            }]);

        if ($this->filters['employee_id']) {
            $query->where('id', $this->filters['employee_id']);
        }

        return $query->get()->toArray();
    }

    public function getSourcePerformance(): array
    {
        $query = Lead::query()
            ->select('contact_source_id', DB::raw('COUNT(*) as total_leads'))
            ->groupBy('contact_source_id')
            ->with('contactSource');

        if ($this->filters['date_from']) {
            $query->whereDate('created_at', '>=', $this->filters['date_from']);
        }
        if ($this->filters['date_to']) {
            $query->whereDate('created_at', '<=', $this->filters['date_to']);
        }
        if ($this->filters['employee_id']) {
            $query->where('assigned_to', $this->filters['employee_id']);
        }
        if ($this->filters['car_id']) {
            $query->where('car_id', $this->filters['car_id']);
        }

        return $query->get()->toArray();
    }

    public function getDetailedBookings(): array
    {
        $query = Booking::query()->latest();
        $query = $this->applyFilters($query);

        return $query->with(['car.brand', 'employee'])->limit(20)->get()->toArray();
    }

    public function getFilterEmployees(): array
    {
        return Employee::query()->pluck('name', 'id')->toArray();
    }

    public function getFilterCars(): array
    {
        return Car::query()->pluck('name', 'id')->toArray();
    }

    public function changeTab(string $tab): void
    {
        $this->activeTab = $tab;
    }

    public function updatedFilters(): void
    {
        $this->dispatch('$refresh');
    }
}
