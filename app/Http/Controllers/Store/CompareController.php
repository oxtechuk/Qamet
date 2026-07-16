<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;

class CompareController extends Controller
{
    public function index(Request $request)
    {
        $slugs = array_filter(array_slice((array) $request->get('cars', []), 0, 2));

        $cars = collect();
        foreach ($slugs as $slug) {
            $car = Car::with(['brand', 'specifications', 'features_list'])
                ->where(function ($q) use ($slug) {
                    $q->where('slug->en', $slug)
                        ->orWhere('slug->ar', $slug);
                })
                ->where('is_active', true)
                ->first();
            if ($car) {
                $cars->push($car);
            }
        }

        $car1 = $cars->get(0);
        $car2 = $cars->get(1);

        // Build structured comparison rows
        $comparisonSections = $this->buildComparisonSections($car1, $car2);

        return view('store.compare.index', compact('car1', 'car2', 'comparisonSections'));
    }

    public function search(Request $request)
    {
        $term = trim($request->get('q', ''));

        $cars = Car::with('brand')
            ->where('is_active', true)
            ->where(function ($q) use ($term) {
                $q->where('name->ar', 'LIKE', "%{$term}%")
                    ->orWhere('name->en', 'LIKE', "%{$term}%")
                    ->orWhereHas('brand', fn ($bq) => $bq->where('name', 'LIKE', "%{$term}%"))
                    ->orWhere('model', 'LIKE', "%{$term}%")
                    ->orWhere('year', 'LIKE', "%{$term}%");
            })
            ->orderByDesc('is_featured')
            ->limit(8)
            ->get(['id', 'name', 'slug', 'thumbnail', 'cash_price', 'year', 'brand_id'])
            ->map(fn ($c) => [
                'slug' => $c->slug,
                'name' => $c->name,
                'year' => $c->year,
                'price' => number_format($c->cash_price),
                'brand' => $c->brand?->name,
                'thumbnail' => $c->thumbnail ? asset('storage/'.$c->thumbnail) : asset('assets/images/placeholder-car.jpg'),
            ]);

        return response()->json($cars);
    }

    private function buildComparisonSections(?Car $car1, ?Car $car2): array
    {
        if (! $car1 || ! $car2) {
            return [];
        }

        $specs1 = $car1->specs ?? [];
        $specs2 = $car2->specs ?? [];

        $sections = [];

        // ===== الأسعار =====
        $sections[] = [
            'title' => 'الأسعار',
            'icon' => 'bi-tag-fill',
            'rows' => [
                $this->row('السعر', $car1->cash_price, $car2->cash_price, 'price', 'lower'),
                $this->row('القسط التقريبي', $car1->min_installment, $car2->min_installment, 'price', 'lower'),
            ],
        ];

        // ===== الأداء =====
        $sections[] = [
            'title' => 'الأداء',
            'icon' => 'bi-speedometer2',
            'rows' => [
                $this->row('القوة', $specs1['hp'] ?? null, $specs2['hp'] ?? null, 'unit', 'higher', 'حصان'),
                $this->row('السرعة القصوى', $specs1['max_speed'] ?? null, $specs2['max_speed'] ?? null, 'unit', 'higher', 'كم/ساعة'),
                $this->row('التسارع', $specs1['acceleration'] ?? null, $specs2['acceleration'] ?? null, 'unit', 'lower', 'ثانية'),
            ],
        ];

        // ===== التصميم =====
        $sections[] = [
            'title' => 'التصميم',
            'icon' => 'bi-palette-fill',
            'rows' => [
                $this->row('نوع', $car1->type, $car2->type, 'text'),
                $this->row('المقاعد', $specs1['seats'] ?? null, $specs2['seats'] ?? null, 'unit', 'neutral', 'مقعد'),
                $this->row('ناقل الحركة', $specs1['gearbox'] ?? null, $specs2['gearbox'] ?? null, 'text'),
            ],
        ];

        // ===== الأمان =====
        $features1Names = $car1->features_list->pluck('name')->toArray();
        $features2Names = $car2->features_list->pluck('name')->toArray();
        $allFeatures = array_unique(array_merge($features1Names, $features2Names));

        $featureRows = [];
        foreach ($allFeatures as $feat) {
            $featureRows[] = [
                'label' => $feat,
                'val1' => in_array($feat, $features1Names) ? '✓' : '✗',
                'val2' => in_array($feat, $features2Names) ? '✓' : '✗',
                'type' => 'check',
                'winner' => match (true) {
                    in_array($feat, $features1Names) && ! in_array($feat, $features2Names) => 1,
                    ! in_array($feat, $features1Names) && in_array($feat, $features2Names) => 2,
                    default => 0,
                },
            ];
        }
        if (! empty($featureRows)) {
            $sections[] = [
                'title' => 'المميزات والأمان',
                'icon' => 'bi-shield-check',
                'rows' => $featureRows,
            ];
        }

        // ===== المواصفات التقنية =====
        $specs1List = $car1->specifications->pluck('name')->toArray();
        $specs2List = $car2->specifications->pluck('name')->toArray();
        $allSpecs = array_unique(array_merge($specs1List, $specs2List));

        $specRows = [];
        foreach ($allSpecs as $spec) {
            $specRows[] = [
                'label' => $spec,
                'val1' => in_array($spec, $specs1List) ? '✓' : '✗',
                'val2' => in_array($spec, $specs2List) ? '✓' : '✗',
                'type' => 'check',
                'winner' => match (true) {
                    in_array($spec, $specs1List) && ! in_array($spec, $specs2List) => 1,
                    ! in_array($spec, $specs1List) && in_array($spec, $specs2List) => 2,
                    default => 0,
                },
            ];
        }
        if (! empty($specRows)) {
            $sections[] = [
                'title' => 'المواصفات التقنية',
                'icon' => 'bi-gear-wide-connected',
                'rows' => $specRows,
            ];
        }

        return $sections;
    }

    private function row(string $label, $val1, $val2, string $type = 'text', string $compare = 'neutral', string $unit = ''): array
    {
        $winner = 0;

        if ($compare !== 'neutral' && $val1 !== null && $val2 !== null) {
            $n1 = (float) preg_replace('/[^0-9.]/', '', $val1);
            $n2 = (float) preg_replace('/[^0-9.]/', '', $val2);

            if ($n1 !== $n2) {
                $winner = match ($compare) {
                    'higher' => $n1 > $n2 ? 1 : 2,
                    'lower' => $n1 < $n2 ? 1 : 2,
                    default => 0,
                };
            }
        }

        $format = fn ($v) => match ($type) {
            'price' => $v ? number_format((float) $v).' '.__('ريال') : '—',
            'unit' => $v ? $v.' '.__($unit) : '—',
            default => $v ?: '—',
        };

        return [
            'label' => $label,
            'val1' => $format($val1),
            'val2' => $format($val2),
            'type' => $type,
            'winner' => $winner,
        ];
    }
}
