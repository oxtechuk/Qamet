<?php

namespace App\Filament\Widgets;

use App\Models\CarCategory;
use Filament\Widgets\ChartWidget;

class TopCategoriesChart extends ChartWidget
{
    protected static ?int $sort = 6;

    public function getHeading(): ?string
    {
        return __('Cars by Category');
    }

    public ?string $heading = null;

    public int|string|array $columnSpan = [
        'xl' => 1,
        'lg' => 2,
        'md' => 2,
        'sm' => 1,
    ];

    protected function getData(): array
    {
        $categories = CarCategory::withCount('cars')
            ->orderByDesc('cars_count')
            ->limit(6)
            ->get();

        $colors = ['#6366f1', '#22c55e', '#eab308', '#ef4444', '#06b6d4', '#f97316'];

        return [
            'datasets' => [
                [
                    'label' => __('Cars'),
                    'data' => $categories->pluck('cars_count')->toArray(),
                    'backgroundColor' => array_slice($colors, 0, $categories->count()),
                    'borderRadius' => 6,
                    'borderSkipped' => false,
                    'barThickness' => 24,
                ],
            ],
            'labels' => $categories->pluck('name')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'indexAxis' => 'y',
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
            ],
            'scales' => [
                'y' => [
                    'grid' => [
                        'display' => false,
                    ],
                    'ticks' => [
                        'font' => [
                            'weight' => '600',
                            'size' => 11,
                        ],
                    ],
                ],
                'x' => [
                    'grid' => [
                        'color' => 'rgba(0,0,0,0.04)',
                    ],
                    'beginAtZero' => true,
                    'ticks' => [
                        'stepSize' => 1,
                    ],
                ],
            ],
        ];
    }
}
