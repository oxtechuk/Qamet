<?php

declare(strict_types=1);

namespace App\Services\Api\Store;

use App\Http\Resources\Store\CarResource;
use App\Models\Car;
use App\Services\Api\Store\Helpers\SlugResolver;

final class CompareApiService
{
    public function compare(array $slugs): array
    {
        $cars = [];
        foreach ($slugs as $slug) {
            $car = $this->loadCar($slug);
            if ($car) {
                $cars[] = $car;
            }
        }

        if (count($cars) < 2) {
            return [];
        }

        return [
            'cars' => CarResource::collection($cars)->resolve(),
            'sections' => $this->buildSections($cars),
        ];
    }

    private function loadCar(string $slug): ?Car
    {
        $query = Car::with([
            'brand',
            'category',
            'images',
            'specifications',
            'features_list',
            'activeOffers',
            'highlight',
        ])
            ->where('is_active', true);

        SlugResolver::applyCarSlug($query, $slug);

        return $query->first();
    }

    private function buildSections(array $cars): array
    {
        return array_filter([
            $this->priceSection($cars),
            $this->performanceSection($cars),
            $this->designSection($cars),
            $this->checkSection(
                __('store-api.compare.sections.features'),
                'features_list',
                $cars,
            ),
            $this->checkSection(
                __('store-api.compare.sections.specs'),
                'specifications',
                $cars,
            ),
        ]);
    }

    private function priceSection(array $cars): array
    {
        $cashPrices = array_map(fn (Car $car) => $car->cash_price, $cars);
        $minInstallments = array_map(fn (Car $car) => $car->min_installment, $cars);

        return [
            'title' => __('store-api.compare.sections.price'),
            'rows' => [
                $this->row(__('store-api.compare.labels.price'), $cashPrices, 'price', 'lower'),
                $this->row(__('store-api.compare.labels.installment'), $minInstallments, 'price', 'lower'),
            ],
        ];
    }

    private function performanceSection(array $cars): array
    {
        $hps = array_map(fn (Car $car) => $car->specs['hp'] ?? null, $cars);
        $maxSpeeds = array_map(fn (Car $car) => $car->specs['max_speed'] ?? null, $cars);
        $accelerations = array_map(fn (Car $car) => $car->specs['acceleration'] ?? null, $cars);

        return [
            'title' => __('store-api.compare.sections.performance'),
            'rows' => [
                $this->row(__('store-api.compare.labels.horsepower'), $hps, 'unit', 'higher', __('store-api.compare.units.hp')),
                $this->row(__('store-api.compare.labels.max_speed'), $maxSpeeds, 'unit', 'higher', __('store-api.compare.units.kmh')),
                $this->row(__('store-api.compare.labels.acceleration'), $accelerations, 'unit', 'lower', __('store-api.compare.units.seconds')),
            ],
        ];
    }

    private function designSection(array $cars): array
    {
        $types = array_map(fn (Car $car) => $car->type, $cars);
        $seats = array_map(fn (Car $car) => $car->specs['seats'] ?? null, $cars);
        $gearboxes = array_map(fn (Car $car) => $car->specs['gearbox'] ?? null, $cars);

        return [
            'title' => __('store-api.compare.sections.design'),
            'rows' => [
                $this->row(__('store-api.compare.labels.type'), $types, 'text'),
                $this->row(__('store-api.compare.labels.seats'), $seats, 'unit', 'neutral', __('store-api.compare.units.seat')),
                $this->row(__('store-api.compare.labels.gearbox'), $gearboxes, 'text'),
            ],
        ];
    }

    private function checkSection(string $title, string $relation, array $cars): ?array
    {
        $carItems = [];
        $all = [];
        foreach ($cars as $car) {
            $items = $car->$relation->pluck('name')->toArray();
            $carItems[] = $items;
            $all = array_merge($all, $items);
        }
        $all = array_unique($all);

        if (empty($all)) {
            return null;
        }

        $rows = [];
        foreach ($all as $item) {
            $values = [];
            $winner = 0;
            $hasCount = 0;
            $firstHasIdx = null;

            foreach ($carItems as $idx => $items) {
                $has = in_array($item, $items);
                $values[] = $has ? '✓' : '✗';
                if ($has) {
                    $hasCount++;
                    if ($firstHasIdx === null) {
                        $firstHasIdx = $idx;
                    }
                }
            }

            if ($hasCount === 1) {
                $winner = $firstHasIdx + 1; // 1-indexed winner: 1, 2, 3
            }

            $row = [
                'label' => $item,
                'type' => 'check',
                'winner' => $winner,
                'values' => $values,
            ];

            // Backward compatibility for val1, val2, val3
            foreach ($values as $idx => $val) {
                $row['val'.($idx + 1)] = $val;
            }

            $rows[] = $row;
        }

        return [
            'title' => $title,
            'rows' => $rows,
        ];
    }

    private function row(string $label, array $rawValues, string $type = 'text', string $compare = 'neutral', string $unit = ''): array
    {
        $winner = 0;
        $values = array_map(fn ($val) => $this->format($val, $type, $unit), $rawValues);

        if ($compare !== 'neutral') {
            $nums = array_map(function ($val) {
                if ($val === null) {
                    return null;
                }

                return (float) preg_replace('/[^0-9.]/', '', (string) $val);
            }, $rawValues);

            $bestVal = null;
            $bestIdx = null;
            foreach ($nums as $idx => $num) {
                if ($num === null) {
                    continue;
                }
                if ($bestVal === null) {
                    $bestVal = $num;
                    $bestIdx = $idx;
                } else {
                    $isBetter = match ($compare) {
                        'higher' => $num > $bestVal,
                        'lower' => $num < $bestVal,
                        default => false,
                    };
                    if ($isBetter) {
                        $bestVal = $num;
                        $bestIdx = $idx;
                    }
                }
            }

            if ($bestIdx !== null) {
                $tie = false;
                foreach ($nums as $idx => $num) {
                    if ($idx !== $bestIdx && $num === $bestVal) {
                        $tie = true;
                        break;
                    }
                }
                $winner = $tie ? 0 : ($bestIdx + 1);
            }
        }

        $row = [
            'label' => $label,
            'type' => $type,
            'winner' => $winner,
            'values' => $values,
        ];

        // Backward compatibility for val1, val2, val3
        foreach ($values as $idx => $val) {
            $row['val'.($idx + 1)] = $val;
        }

        return $row;
    }

    private function format(mixed $value, string $type, string $unit): string
    {
        if ($value === null) {
            return '—';
        }

        $riyal = __('store-api.compare.units.riyal');

        return match ($type) {
            'price' => number_format((float) $value)." {$riyal}",
            'unit' => $value." {$unit}",
            default => (string) $value,
        };
    }
}
