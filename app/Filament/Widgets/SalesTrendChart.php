<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class SalesTrendChart extends ChartWidget
{
    protected static bool $isLazy = true;

    protected static ?int $sort = 4;

    public function getHeading(): ?string
    {
        return __('Sales Trend');
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
        $currentMonth = (int) now()->format('n');
        $driver = DB::connection()->getDriverName();
        $monthExpr = $driver === 'sqlite'
            ? "CAST(strftime('%m', created_at) AS INTEGER)"
            : 'MONTH(created_at)';
        $yearExpr = $driver === 'sqlite'
            ? "CAST(strftime('%Y', created_at) AS INTEGER)"
            : 'YEAR(created_at)';

        $sales = Booking::select(
            DB::raw("{$monthExpr} as month"),
            DB::raw("{$yearExpr} as year"),
            DB::raw("SUM(CASE WHEN status = 'sold' THEN 1 ELSE 0 END) as completed"),
            DB::raw('COUNT(*) as total')
        )
            ->whereYear('created_at', now()->year)
            ->groupBy(DB::raw($yearExpr), DB::raw($monthExpr))
            ->orderBy('month')
            ->get()
            ->keyBy('month');

        $months = collect(range(1, $currentMonth))->map(function ($month) use ($sales) {
            $data = $sales->get($month);

            return [
                'completed' => $data ? $data->completed : 0,
                'total' => $data ? $data->total : 0,
            ];
        });

        return [
            'datasets' => [
                [
                    'label' => __('Completed'),
                    'data' => $months->pluck('completed')->toArray(),
                    'backgroundColor' => 'rgba(16, 185, 129, 0.85)',
                    'borderRadius' => 6,
                    'borderSkipped' => false,
                ],
                [
                    'label' => __('Total Orders'),
                    'data' => $months->pluck('total')->toArray(),
                    'backgroundColor' => 'rgba(99, 102, 241, 0.6)',
                    'borderRadius' => 6,
                    'borderSkipped' => false,
                ],
            ],
            'labels' => collect(range(1, $currentMonth))->map(function ($m) {
                return date('M', mktime(0, 0, 0, $m, 1));
            })->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'position' => 'top',
                    'labels' => [
                        'usePointStyle' => true,
                        'padding' => 16,
                        'font' => [
                            'weight' => '600',
                        ],
                    ],
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'grid' => [
                        'color' => 'rgba(0,0,0,0.04)',
                    ],
                    'ticks' => [
                        'stepSize' => 1,
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
