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
    public static function canAccess(): bool
    {
        $user = \Illuminate\Support\Facades\Auth::guard('employee')->user();

        return $user && ($user->isAdmin() || $user->hasPermission('manage-reports'));
    }

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
        $this->filters['date_from'] = now()->startOfMonth()->toDateString();
        $this->filters['date_to'] = now()->endOfMonth()->toDateString();
    }

    public function setQuickFilter(string $period): void
    {
        match ($period) {
            'today' => [
                $this->filters['date_from'] = now()->toDateString(),
                $this->filters['date_to'] = now()->toDateString(),
            ],
            'week' => [
                $this->filters['date_from'] = now()->startOfWeek()->toDateString(),
                $this->filters['date_to'] = now()->endOfWeek()->toDateString(),
            ],
            'month' => [
                $this->filters['date_from'] = now()->startOfMonth()->toDateString(),
                $this->filters['date_to'] = now()->endOfMonth()->toDateString(),
            ],
            'quarter' => [
                $this->filters['date_from'] = now()->startOfQuarter()->toDateString(),
                $this->filters['date_to'] = now()->endOfQuarter()->toDateString(),
            ],
            'year' => [
                $this->filters['date_from'] = now()->startOfYear()->toDateString(),
                $this->filters['date_to'] = now()->endOfYear()->toDateString(),
            ],
            default => null,
        };
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

        $total = (clone $query)->count();
        $sold = (clone $query)->where('status', 'sold')->count();
        $revenue = (clone $query)->where('status', 'sold')->sum('total_price');
        $downPayments = (clone $query)->whereNotNull('down_payment')->sum('down_payment');
        $avgDown = (clone $query)->whereNotNull('down_payment')->avg('down_payment') ?? 0;
        $avgMonthly = (clone $query)->whereNotNull('monthly_installment')->avg('monthly_installment') ?? 0;
        $avgDuration = (clone $query)->whereNotNull('duration_years')->avg('duration_years') ?? 0;

        // Previous period for comparison
        $prev = $this->getPreviousPeriodBookings();

        return [
            'total_bookings' => $total,
            'sold_count' => $sold,
            'total_revenue' => $revenue,
            'total_down_payments' => $downPayments,
            'avg_down_payment' => $avgDown,
            'avg_monthly' => $avgMonthly,
            'avg_duration' => $avgDuration,
            'prev_total' => $prev['total'],
            'prev_sold' => $prev['sold'],
            'prev_revenue' => $prev['revenue'],
        ];
    }

    protected function getPreviousPeriodBookings(): array
    {
        $from = $this->filters['date_from'];
        $to = $this->filters['date_to'];

        if (! $from || ! $to) {
            return ['total' => 0, 'sold' => 0, 'revenue' => 0];
        }

        $fromDate = \Carbon\Carbon::parse($from);
        $toDate = \Carbon\Carbon::parse($to);
        $diff = $fromDate->diffInDays($toDate) + 1;

        $prevFrom = $fromDate->copy()->subDays($diff)->toDateString();
        $prevTo = $fromDate->copy()->subDay()->toDateString();

        $query = Booking::query()
            ->whereDate('created_at', '>=', $prevFrom)
            ->whereDate('created_at', '<=', $prevTo);

        return [
            'total' => (clone $query)->count(),
            'sold' => (clone $query)->where('status', 'sold')->count(),
            'revenue' => (clone $query)->where('status', 'sold')->sum('total_price'),
        ];
    }

    public function getBookingStatusBreakdown(): array
    {
        $query = Booking::query();
        $query = $this->applyFilters($query);

        $statuses = array_keys(Booking::STATUSES);
        $result = [];

        foreach ($statuses as $status) {
            $result[$status] = (clone $query)->where('status', $status)->count();
        }

        return $result;
    }

    public function getKpiBar(): array
    {
        $query = Booking::query();
        $query = $this->applyFilters($query);
        $totalBookings = (clone $query)->count();
        $soldCount = (clone $query)->where('status', 'sold')->count();

        $leadsQuery = Lead::query();
        if ($this->filters['date_from']) {
            $leadsQuery->whereDate('created_at', '>=', $this->filters['date_from']);
        }
        if ($this->filters['date_to']) {
            $leadsQuery->whereDate('created_at', '<=', $this->filters['date_to']);
        }
        $totalLeads = (clone $leadsQuery)->count();
        $newLeads = (clone $leadsQuery)->where('status', 'new')->count();

        $convRate = $totalLeads > 0 ? round(($soldCount / $totalLeads) * 100, 1) : 0;

        $revenue = (clone $query)->where('status', 'sold')->sum('total_price');

        return [
            'total_bookings' => $totalBookings,
            'sold_count' => $soldCount,
            'total_revenue' => $revenue,
            'total_leads' => $totalLeads,
            'new_leads' => $newLeads,
            'conv_rate' => $convRate,
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

        return $query->orderByDesc('sold_bookings')->get()->toArray();
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

    public function getLeadsStats(): array
    {
        $query = Lead::query();

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

        $statuses = array_keys(Lead::STATUSES);
        $result = ['total' => (clone $query)->count()];

        foreach ($statuses as $status) {
            $result[$status] = (clone $query)->where('status', $status)->count();
        }

        return $result;
    }

    public function getLeadsPipeline(): array
    {
        $query = Lead::query()->latest()->with(['car.brand', 'employee', 'contactSource']);

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

        return $query->limit(15)->get()->toArray();
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
