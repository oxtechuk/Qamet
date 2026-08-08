<?php

namespace App\Filament\Widgets;

use App\Models\Brand;
use Filament\Widgets\ChartWidget;

class TopBrandsChart extends ChartWidget
{
    protected static bool $isLazy = true;

    protected static ?int $sort = 5;

    public function getHeading(): ?string
    {
        return __('Top Brands');
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
        $brands = Brand::withCount('cars')
            ->orderByDesc('cars_count')
            ->limit(6)
            ->get();

        $colors = ['#6366f1', '#8b5cf6', '#a855f7', '#d946ef', '#ec4899', '#f43f5e'];

        return [
            'datasets' => [
                [
                    'data' => $brands->pluck('cars_count')->toArray(),
                    'backgroundColor' => array_slice($colors, 0, $brands->count()),
                    'borderWidth' => 3,
                    'borderColor' => '#fff',
                    'hoverOffset' => 8,
                ],
            ],
            'labels' => $brands->pluck('name')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'position' => 'bottom',
                    'labels' => [
                        'padding' => 14,
                        'usePointStyle' => true,
                        'font' => [
                            'weight' => '600',
                            'size' => 11,
                        ],
                    ],
                ],
            ],
            'cutout' => '72%',
        ];
    }
}
