<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class MonthlyRevenueChart extends ChartWidget
{
    protected static ?int $sort = 3;

    public function getHeading(): ?string
    {
        return __('Monthly Revenue');
    }

    public ?string $heading = null;

    public int|string|array $columnSpan = [
        'xl' => 2,
        'lg' => 2,
        'md' => 2,
        'sm' => 1,
    ];

    protected function getData(): array
    {
        $revenue = Booking::where('status', 'sold')
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('SUM(total_price) as total')
            )
            ->whereYear('created_at', now()->year)
            ->groupBy('year', 'month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $currentMonth = (int) now()->format('n');
        $months = collect(range(1, $currentMonth))->map(function ($month) use ($revenue) {
            return isset($revenue[$month]) ? (int) $revenue[$month] : 0;
        })->toArray();

        return [
            'datasets' => [
                [
                    'label' => __('Revenue (SAR)'),
                    'data' => $months,
                    'backgroundColor' => 'rgba(99, 102, 241, 0.08)',
                    'borderColor' => 'rgba(99, 102, 241, 1)',
                    'fill' => true,
                    'tension' => 0.4,
                    'borderWidth' => 2.5,
                    'pointBackgroundColor' => 'rgba(99, 102, 241, 1)',
                    'pointBorderColor' => '#fff',
                    'pointBorderWidth' => 2,
                    'pointRadius' => 4,
                    'pointHoverRadius' => 7,
                ],
            ],
            'labels' => collect(range(1, $currentMonth))->map(function ($m) {
                return date('M', mktime(0, 0, 0, $m, 1));
            })->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'grid' => [
                        'color' => 'rgba(0,0,0,0.04)',
                    ],
                    'ticks' => [
                        'callback' => "function(value) { return value.toLocaleString() + ' ".__('SAR')."'; }",
                    ],
                ],
                'x' => [
                    'grid' => [
                        'display' => false,
                    ],
                ],
            ],
        ];
    }
}
