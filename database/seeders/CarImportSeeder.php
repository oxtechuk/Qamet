<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Car;
use App\Models\CarCategory;
use App\Models\Feature;
use App\Models\Specification;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CarImportSeeder extends Seeder
{
    public function run(): void
    {
        $jsonPath = database_path('data/cars.json');

        if (!File::exists($jsonPath)) {
            $this->command->error("JSON file not found at: {$jsonPath}");
            return;
        }

        $jsonContent = File::get($jsonPath);
        $carsData = json_decode($jsonContent, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->command->error("Invalid JSON format: " . json_last_error_msg());
            return;
        }

        $typeMapping = [
            'sedan' => ['ar' => 'سيدان', 'en' => 'Sedan'],
            'suv' => ['ar' => 'سيارات دفع رباعي', 'en' => 'SUVs'],
            'coupe' => ['ar' => 'كوبيه', 'en' => 'Coupe'],
            'hatchback' => ['ar' => 'هاتشباك', 'en' => 'Hatchback'],
            'pickup' => ['ar' => 'بيك آب', 'en' => 'Pickup'],
            'van' => ['ar' => 'فان', 'en' => 'Van'],
            'other' => ['ar' => 'أخرى', 'en' => 'Other'],
        ];

        $specMapping = [
            'Engine' => ['ar' => 'المحرك', 'en' => 'Engine'],
            'Transmission' => ['ar' => 'ناقل الحركة', 'en' => 'Transmission'],
            'Fuel Type' => ['ar' => 'نوع الوقود', 'en' => 'Fuel Type'],
            'Seats' => ['ar' => 'عدد المقاعد', 'en' => 'Seats'],
        ];

        foreach ($carsData as $carData) {
            // 1. Create or Find Brand
            $brandInfo = $carData['brand'];
            $brand = Brand::updateOrCreate(
                ['slug' => $brandInfo['slug']],
                [
                    'name' => [
                        'ar' => $brandInfo['ar'],
                        'en' => $brandInfo['en']
                    ],
                    'is_active' => true
                ]
            );

            // 2. Create or Find Category
            $type = $carData['type'] ?? 'sedan';
            $categoryNames = $typeMapping[$type] ?? ['ar' => 'سيدان', 'en' => 'Sedan'];
            $category = CarCategory::updateOrCreate(
                ['slug' => $type],
                [
                    'name' => [
                        'ar' => $categoryNames['ar'],
                        'en' => $categoryNames['en']
                    ],
                    'is_active' => true,
                    'sort_order' => 1
                ]
            );

            // 3. Prepare Specs List
            $specsList = [];
            $specificationIds = [];
            foreach ($carData['specs'] as $spec) {
                $label = $spec['label'];
                $value = $spec['value'];

                // Translate label if available
                $specNames = $specMapping[$label] ?? ['ar' => $label, 'en' => $label];
                $specification = Specification::updateOrCreate(
                    ['name->en' => $specNames['en']],
                    [
                        'name' => [
                            'ar' => $specNames['ar'],
                            'en' => $specNames['en']
                        ],
                        'icon' => $this->getSpecIcon($label)
                    ]
                );
                $specificationIds[] = $specification->id;

                $specsList[] = [
                    'label' => $label,
                    'value' => $value
                ];
            }

            // 4. Prepare Features List
            $featureIds = [];
            $featuresAr = array_map('trim', explode('،', $carData['features_text']['ar']));
            $featuresEn = array_map('trim', explode(',', $carData['features_text']['en']));

            // Ensure equal size or safe fallback
            $maxCount = max(count($featuresAr), count($featuresEn));
            for ($i = 0; $i < $maxCount; $i++) {
                $featAr = $featuresAr[$i] ?? ($featuresAr[0] ?? '');
                $featEn = $featuresEn[$i] ?? ($featuresEn[0] ?? '');

                if (empty($featAr) && empty($featEn)) continue;

                $feature = Feature::updateOrCreate(
                    ['name->en' => $featEn],
                    [
                        'name' => [
                            'ar' => $featAr,
                            'en' => $featEn
                        ],
                        'icon' => 'bi bi-patch-check'
                    ]
                );
                $featureIds[] = $feature->id;
            }

            // 5. Generate Unique Slugs
            $slugAr = Car::generateUniqueSlug($carData['name']['ar'], $carData['year'], 'ar');
            $slugEn = Car::generateUniqueSlug($carData['name']['en'], $carData['year'], 'en');

            // 6. Create Car
            $car = Car::updateOrCreate(
                [
                    'name->ar' => $carData['name']['ar'],
                    'year' => $carData['year']
                ],
                [
                    'brand_id' => $brand->id,
                    'category_id' => $category->id,
                    'name' => [
                        'ar' => $carData['name']['ar'],
                        'en' => $carData['name']['en']
                    ],
                    'slug' => [
                        'ar' => $slugAr,
                        'en' => $slugEn
                    ],
                    'model' => $carData['model'],
                    'type' => $type,
                    'cash_price' => $carData['cash_price'],
                    'min_down_payment' => $carData['min_down_payment'],
                    'min_installment' => $carData['min_installment'],
                    'description' => [
                        'ar' => $carData['description']['ar'],
                        'en' => $carData['description']['en']
                    ],
                    'features' => [
                        'ar' => $carData['features_text']['ar'],
                        'en' => $carData['features_text']['en']
                    ],
                    'specs' => $specsList,
                    'colors' => [
                        ['name' => 'أبيض / White', 'hex' => '#FFFFFF'],
                        ['name' => 'أسود / Black', 'hex' => '#000000'],
                        ['name' => 'فضي / Silver', 'hex' => '#C0C0C0']
                    ],
                    'is_featured' => true,
                    'is_active' => true,
                    'is_highlighted' => 'none',
                    'availability_status' => 'available'
                ]
            );

            // 7. Sync Pivot Tables
            $car->specifications()->sync($specificationIds);
            $car->features_list()->sync($featureIds);
        }

        $this->command->info("Successfully imported " . count($carsData) . " cars!");
    }

    private function getSpecIcon(string $label): string
    {
        return match (strtolower($label)) {
            'engine' => 'bi bi-gear-wide-connected',
            'transmission' => 'bi bi-command',
            'fuel type' => 'bi bi-fuel-pump',
            'seats' => 'bi bi-people',
            default => 'bi bi-info-circle',
        };
    }
}
