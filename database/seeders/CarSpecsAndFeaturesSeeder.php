<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\Feature;
use App\Models\SafetyFeature;
use App\Models\Specification;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CarSpecsAndFeaturesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clean up existing pivot and main tables
        DB::table('car_specification')->delete();
        DB::table('car_feature')->delete();
        DB::table('car_safety_feature')->delete();

        Specification::query()->delete();
        Feature::query()->delete();
        SafetyFeature::query()->delete();

        // 1. Seed Specifications
        $specificationsData = [
            [
                'name_ar' => 'المحرك',
                'name_en' => 'Engine',
                'value_ar' => '2.5 لتر 4 سلندر',
                'value_en' => '2.5L 4-Cylinder',
                'icon' => 'heroicon-o-cpu-chip',
            ],
            [
                'name_ar' => 'ناقل الحركة',
                'name_en' => 'Transmission',
                'value_ar' => 'أوتوماتيكي 8 سرعات',
                'value_en' => '8-Speed Automatic',
                'icon' => 'heroicon-o-cog',
            ],
            [
                'name_ar' => 'نوع الوقود',
                'name_en' => 'Fuel Type',
                'value_ar' => 'بنزين 91',
                'value_en' => 'Petrol 91',
                'icon' => 'heroicon-o-bolt',
            ],
            [
                'name_ar' => 'استهلاك الوقود',
                'name_en' => 'Fuel Economy',
                'value_ar' => '16.3 كم/لتر',
                'value_en' => '16.3 km/L',
                'icon' => 'heroicon-o-academic-cap',
            ],
            [
                'name_ar' => 'نظام الدفع',
                'name_en' => 'Drivetrain',
                'value_ar' => 'دفع أمامي',
                'value_en' => 'Front Wheel Drive (FWD)',
                'icon' => 'heroicon-o-arrow-path',
            ],
            [
                'name_ar' => 'عدد المقاعد',
                'name_en' => 'Seats',
                'value_ar' => '5 مقاعد',
                'value_en' => '5 Seats',
                'icon' => 'heroicon-o-users',
            ],
            [
                'name_ar' => 'القوة الحصانية',
                'name_en' => 'Horsepower',
                'value_ar' => '204 حصان',
                'value_en' => '204 HP',
                'icon' => 'heroicon-o-fire',
            ],
            [
                'name_ar' => 'حجم خزان الوقود',
                'name_en' => 'Fuel Tank Capacity',
                'value_ar' => '60 لتر',
                'value_en' => '60 Liters',
                'icon' => 'heroicon-o-scale',
            ],
        ];

        $specifications = [];
        foreach ($specificationsData as $data) {
            $specifications[] = Specification::create($data);
        }

        // 2. Seed Features
        $featuresData = [
            [
                'name_ar' => 'فتحة سقف بانورامية',
                'name_en' => 'Panoramic Sunroof',
                'value_ar' => 'نعم',
                'value_en' => 'Yes',
                'icon' => 'heroicon-o-sun',
            ],
            [
                'name_ar' => 'مقاعد جلدية فاخرة',
                'name_en' => 'Premium Leather Seats',
                'value_ar' => 'نعم',
                'value_en' => 'Yes',
                'icon' => 'heroicon-o-squares-plus',
            ],
            [
                'name_ar' => 'دخول ذكي بدون مفتاح',
                'name_en' => 'Smart Keyless Entry',
                'value_ar' => 'نعم',
                'value_en' => 'Yes',
                'icon' => 'heroicon-o-key',
            ],
            [
                'name_ar' => 'تشغيل بصمة (زر تشغيل)',
                'name_en' => 'Push Button Start',
                'value_ar' => 'نعم',
                'value_en' => 'Yes',
                'icon' => 'heroicon-o-stop-circle',
            ],
            [
                'name_ar' => 'شاشة لمس مقاس 10 بوصة',
                'name_en' => '10-inch Touch Screen',
                'value_ar' => 'نعم',
                'value_en' => 'Yes',
                'icon' => 'heroicon-o-tv',
            ],
            [
                'name_ar' => 'أبل كاربلاي وأندرويد أوتو لاسلكي',
                'name_en' => 'Wireless Apple CarPlay & Android Auto',
                'value_ar' => 'نعم',
                'value_en' => 'Yes',
                'icon' => 'heroicon-o-device-phone-mobile',
            ],
            [
                'name_ar' => 'شاحن لاسلكي للهواتف ذكية',
                'name_en' => 'Wireless Phone Charger',
                'value_ar' => 'نعم',
                'value_en' => 'Yes',
                'icon' => 'heroicon-o-bolt',
            ],
            [
                'name_ar' => 'نظام تكييف خلفي مستقل',
                'name_en' => 'Independent Rear A/C',
                'value_ar' => 'نعم',
                'value_en' => 'Yes',
                'icon' => 'heroicon-o-wind',
            ],
            [
                'name_ar' => 'تهوية وتدفئة المقاعد الأمامية',
                'name_en' => 'Front Seats Ventilation & Heating',
                'value_ar' => 'نعم',
                'value_en' => 'Yes',
                'icon' => 'heroicon-o-sparkles',
            ],
        ];

        $features = [];
        foreach ($featuresData as $data) {
            $features[] = Feature::create($data);
        }

        // 3. Seed Safety Features
        $safetyFeaturesData = [
            [
                'name_ar' => 'نظام فرامل مانع للانغلاق (ABS)',
                'name_en' => 'Anti-lock Braking System (ABS)',
                'value_ar' => 'نعم',
                'value_en' => 'Yes',
                'icon' => 'heroicon-o-shield-exclamation',
            ],
            [
                'name_ar' => 'نظام مراقبة النقاط العمياء',
                'name_en' => 'Blind Spot Monitor',
                'value_ar' => 'نعم',
                'value_en' => 'Yes',
                'icon' => 'heroicon-o-eye',
            ],
            [
                'name_ar' => 'مثبت سرعة ذكي تكيفي',
                'name_en' => 'Adaptive Cruise Control',
                'value_ar' => 'نعم',
                'value_en' => 'Yes',
                'icon' => 'heroicon-o-adjustments-horizontal',
            ],
            [
                'name_ar' => 'كاميرات محيطية 360 درجة',
                'name_en' => '360 Degree Surround Camera',
                'value_ar' => 'نعم',
                'value_en' => 'Yes',
                'icon' => 'heroicon-o-camera',
            ],
            [
                'name_ar' => 'تنبيه مغادرة المسار ومساعد البقاء فيه',
                'name_en' => 'Lane Departure Warning & Keep Assist',
                'value_ar' => 'نعم',
                'value_en' => 'Yes',
                'icon' => 'heroicon-o-arrows-right-left',
            ],
            [
                'name_ar' => 'حساسات ركن أمامية وخلفية',
                'name_en' => 'Front and Rear Parking Sensors',
                'value_ar' => 'نعم',
                'value_en' => 'Yes',
                'icon' => 'heroicon-o-signal',
            ],
            [
                'name_ar' => 'نظام التحذير من الاصطدام الأمامي',
                'name_en' => 'Forward Collision Warning',
                'value_ar' => 'نعم',
                'value_en' => 'Yes',
                'icon' => 'heroicon-o-bell',
            ],
            [
                'name_ar' => 'وسائد هوائية محيطية كاملة',
                'name_en' => 'Full SRS Airbags',
                'value_ar' => 'نعم',
                'value_en' => 'Yes',
                'icon' => 'heroicon-o-lifebuoy',
            ],
        ];

        $safetyFeatures = [];
        foreach ($safetyFeaturesData as $data) {
            $safetyFeatures[] = SafetyFeature::create($data);
        }

        // 4. Attach to existing cars
        $cars = Car::all();

        if ($cars->isEmpty()) {
            $this->command?->warn('No cars found in database. Seed cars first.');

            return;
        }

        foreach ($cars as $car) {
            // Attach 4-6 random specifications
            $specsIds = collect($specifications)->random(rand(4, 6))->pluck('id')->toArray();
            $car->specifications()->sync($specsIds);

            // Attach 4-7 random features
            $featIds = collect($features)->random(rand(4, 7))->pluck('id')->toArray();
            $car->features_list()->sync($featIds);

            // Attach 4-7 random safety features
            $safetyIds = collect($safetyFeatures)->random(rand(4, 7))->pluck('id')->toArray();
            $car->safety_features()->sync($safetyIds);
        }

        $this->command?->info('Specifications, Features, and Safety Features successfully seeded and attached to cars!');
    }
}
