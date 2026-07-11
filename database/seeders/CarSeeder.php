<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Car;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            [
                'name' => ['en' => 'Toyota', 'ar' => 'تويوتا'],
                'slug' => 'toyota',
                'is_active' => true,
            ],
            [
                'name' => ['en' => 'BMW', 'ar' => 'بي إم دبليو'],
                'slug' => 'bmw',
                'is_active' => true,
            ],
        ];

        foreach ($brands as $data) {
            Brand::query()->updateOrCreate(['slug' => $data['slug']], $data);
        }

        $toyota = Brand::where('slug', 'toyota')->first();
        $bmw = Brand::where('slug', 'bmw')->first();

        $cars = [
            [
                'brand_id' => $toyota->id,
                'name' => ['en' => 'Toyota Camry', 'ar' => 'تويوتا كامري'],
                'slug' => ['en' => 'toyota-camry', 'ar' => 'تويوتا-كامري'],
                'model' => 'Camry',
                'year' => 2025,
                'type' => 'sedan',
                'cash_price' => 125000,
                'min_down_payment' => 25000,
                'min_installment' => 3500,
                'specs' => [
                    ['label' => 'Engine', 'value' => '2.5L 4-Cylinder'],
                    ['label' => 'Horsepower', 'value' => '203 HP'],
                    ['label' => 'Fuel Type', 'value' => 'Petrol'],
                    ['label' => 'Transmission', 'value' => 'Automatic'],
                    ['label' => 'Seats', 'value' => '5'],
                ],
                'colors' => [
                    ['name' => 'White', 'hex' => '#FFFFFF'],
                    ['name' => 'Black', 'hex' => '#000000'],
                    ['name' => 'Silver', 'hex' => '#C0C0C0'],
                ],
                'description' => ['en' => 'A reliable and comfortable sedan with advanced safety features.', 'ar' => 'سيارة سيدان موثوقة ومريحة مع ميزات أمان متقدمة.'],
                'features' => ['en' => 'Sunroof, Leather Seats, Backup Camera', 'ar' => 'سقف بانورامي، مقاعد جلدية، كاميرا خلفية'],
                'is_featured' => true,
                'is_active' => true,
                'is_highlighted' => 'featured',
                'availability_status' => 'available',
            ],
            [
                'brand_id' => $toyota->id,
                'name' => ['en' => 'Toyota RAV4', 'ar' => 'تويوتا راف فور'],
                'slug' => ['en' => 'toyota-rav4', 'ar' => 'تويوتا-راف-فور'],
                'model' => 'RAV4',
                'year' => 2025,
                'type' => 'suv',
                'cash_price' => 145000,
                'min_down_payment' => 29000,
                'min_installment' => 4000,
                'specs' => [
                    ['label' => 'Engine', 'value' => '2.5L 4-Cylinder'],
                    ['label' => 'Horsepower', 'value' => '219 HP'],
                    ['label' => 'Fuel Type', 'value' => 'Petrol'],
                    ['label' => 'Transmission', 'value' => 'Automatic'],
                    ['label' => 'Seats', 'value' => '5'],
                ],
                'colors' => [
                    ['name' => 'Blue', 'hex' => '#0000FF'],
                    ['name' => 'White', 'hex' => '#FFFFFF'],
                    ['name' => 'Gray', 'hex' => '#808080'],
                ],
                'description' => ['en' => 'A versatile SUV with spacious interior and all-wheel drive capability.', 'ar' => 'سيارة دفع رباعي متعددة الاستخدامات مع مقصورة داخلية واسعة.'],
                'features' => ['en' => 'AWD, Panoramic Roof, Apple CarPlay', 'ar' => 'دفع رباعي، سقف بانورامي، أبل كاربلاي'],
                'is_featured' => true,
                'is_active' => true,
                'is_highlighted' => 'featured',
                'availability_status' => 'available',
            ],
            [
                'brand_id' => $toyota->id,
                'name' => ['en' => 'Toyota Land Cruiser', 'ar' => 'تويوتا لاند كروزر'],
                'slug' => ['en' => 'toyota-land-cruiser', 'ar' => 'تويوتا-لاند-كروزر'],
                'model' => 'Land Cruiser 300',
                'year' => 2025,
                'type' => 'suv',
                'cash_price' => 320000,
                'min_down_payment' => 64000,
                'min_installment' => 8500,
                'specs' => [
                    ['label' => 'Engine', 'value' => '3.5L V6 Twin-Turbo'],
                    ['label' => 'Horsepower', 'value' => '409 HP'],
                    ['label' => 'Fuel Type', 'value' => 'Petrol'],
                    ['label' => 'Transmission', 'value' => 'Automatic 10-Speed'],
                    ['label' => 'Seats', 'value' => '7'],
                ],
                'colors' => [
                    ['name' => 'White', 'hex' => '#FFFFFF'],
                    ['name' => 'Black', 'hex' => '#000000'],
                    ['name' => 'Beige', 'hex' => '#F5F5DC'],
                ],
                'description' => ['en' => 'The ultimate luxury off-road SUV with unmatched durability and prestige.', 'ar' => 'سيارة الدفع الرباعي الفاخرة الفائقة مع متانة وهيبة لا تضاهى.'],
                'features' => ['en' => 'Multi-Terrain Select, Adaptive Cruise Control, Luxury Interior', 'ar' => 'اختيار التضاريس المتعددة، مثبت سرعة تكيفي، مقصورة فاخرة'],
                'is_featured' => true,
                'is_active' => true,
                'is_highlighted' => 'featured',
                'availability_status' => 'available',
            ],
            [
                'brand_id' => $toyota->id,
                'name' => ['en' => 'Toyota Corolla', 'ar' => 'تويوتا كورولا'],
                'slug' => ['en' => 'toyota-corolla', 'ar' => 'تويوتا-كورولا'],
                'model' => 'Corolla LE',
                'year' => 2025,
                'type' => 'sedan',
                'cash_price' => 95000,
                'min_down_payment' => 19000,
                'min_installment' => 2700,
                'specs' => [
                    ['label' => 'Engine', 'value' => '1.8L 4-Cylinder'],
                    ['label' => 'Horsepower', 'value' => '139 HP'],
                    ['label' => 'Fuel Type', 'value' => 'Petrol'],
                    ['label' => 'Transmission', 'value' => 'CVT'],
                    ['label' => 'Seats', 'value' => '5'],
                ],
                'colors' => [
                    ['name' => 'Silver', 'hex' => '#C0C0C0'],
                    ['name' => 'White', 'hex' => '#FFFFFF'],
                    ['name' => 'Red', 'hex' => '#FF0000'],
                ],
                'description' => ['en' => 'The iconic compact sedan known for exceptional fuel economy and reliability.', 'ar' => 'سيارة السيدان المدمجة الشهيرة المعروفة باقتصادها الاستثنائي في الوقود وموثوقيتها.'],
                'features' => ['en' => 'LED Headlights, Touchscreen Display, Lane Departure Alert', 'ar' => 'مصابيح LED أمامية، شاشة لمس، تنبيه مغادرة المسار'],
                'is_featured' => true,
                'is_active' => true,
                'is_highlighted' => 'none',
                'availability_status' => 'available',
            ],
            [
                'brand_id' => $bmw->id,
                'name' => ['en' => 'BMW X5', 'ar' => 'بي إم دبليو X5'],
                'slug' => ['en' => 'bmw-x5', 'ar' => 'بي-إم-دبليو-x5'],
                'model' => 'X5 xDrive40i',
                'year' => 2025,
                'type' => 'suv',
                'cash_price' => 280000,
                'min_down_payment' => 56000,
                'min_installment' => 7500,
                'specs' => [
                    ['label' => 'Engine', 'value' => '3.0L I6 Twin-Turbo'],
                    ['label' => 'Horsepower', 'value' => '375 HP'],
                    ['label' => 'Fuel Type', 'value' => 'Petrol'],
                    ['label' => 'Transmission', 'value' => 'Automatic 8-Speed'],
                    ['label' => 'Seats', 'value' => '7'],
                ],
                'colors' => [
                    ['name' => 'Black', 'hex' => '#000000'],
                    ['name' => 'White', 'hex' => '#FFFFFF'],
                    ['name' => 'Blue', 'hex' => '#0000FF'],
                ],
                'description' => ['en' => 'A premium luxury SUV combining sporty performance with executive comfort.', 'ar' => 'سيارة دفع رباعي فاخرة تجمع بين الأداء الرياضي والراحة التنفيذية.'],
                'features' => ['en' => 'Panoramic Roof, Harman Kardon Sound, Head-Up Display', 'ar' => 'سقف بانورامي، نظام هارمان كاردون، عرض على الزجاج الأمامي'],
                'is_featured' => true,
                'is_active' => true,
                'is_highlighted' => 'featured',
                'availability_status' => 'available',
            ],
            [
                'brand_id' => $bmw->id,
                'name' => ['en' => 'BMW 5 Series', 'ar' => 'بي إم دبليو الفئة الخامسة'],
                'slug' => ['en' => 'bmw-5-series', 'ar' => 'بي-إم-دبليو-الفئة-الخامسة'],
                'model' => '530e M Sport',
                'year' => 2025,
                'type' => 'sedan',
                'cash_price' => 235000,
                'min_down_payment' => 47000,
                'min_installment' => 6300,
                'specs' => [
                    ['label' => 'Engine', 'value' => '2.0L I4 Plug-In Hybrid'],
                    ['label' => 'Horsepower', 'value' => '288 HP'],
                    ['label' => 'Fuel Type', 'value' => 'Hybrid'],
                    ['label' => 'Transmission', 'value' => 'Automatic 8-Speed'],
                    ['label' => 'Seats', 'value' => '5'],
                ],
                'colors' => [
                    ['name' => 'Alpine White', 'hex' => '#F8F8F8'],
                    ['name' => 'Carbon Black', 'hex' => '#1A1A1A'],
                    ['name' => 'Sunset Orange', 'hex' => '#FF6B35'],
                ],
                'description' => ['en' => 'An executive sedan with cutting-edge technology and hybrid efficiency.', 'ar' => 'سيارة سيدان تنفيذية بتقنية متطورة وكفاءة هجينة.'],
                'features' => ['en' => 'Laser Headlights, Wireless Charging, Parking Assistant Plus', 'ar' => 'مصابيح ليزر أمامية، شحن لاسلكي، مساعد ركن متطور'],
                'is_featured' => true,
                'is_active' => true,
                'is_highlighted' => 'featured',
                'availability_status' => 'available',
            ],
            [
                'brand_id' => $bmw->id,
                'name' => ['en' => 'BMW 7 Series', 'ar' => 'بي إم دبليو الفئة السابعة'],
                'slug' => ['en' => 'bmw-7-series', 'ar' => 'بي-إم-دبليو-الفئة-السابعة'],
                'model' => '740i xDrive',
                'year' => 2025,
                'type' => 'sedan',
                'cash_price' => 380000,
                'min_down_payment' => 76000,
                'min_installment' => 10000,
                'specs' => [
                    ['label' => 'Engine', 'value' => '3.0L I6 Twin-Turbo'],
                    ['label' => 'Horsepower', 'value' => '375 HP'],
                    ['label' => 'Fuel Type', 'value' => 'Petrol'],
                    ['label' => 'Transmission', 'value' => 'Automatic 8-Speed'],
                    ['label' => 'Seats', 'value' => '5'],
                ],
                'colors' => [
                    ['name' => 'Black Sapphire', 'hex' => '#0D0D0D'],
                    ['name' => 'Mineral White', 'hex' => '#F0F0F0'],
                    ['name' => 'Tanzanite Blue', 'hex' => '#1A2B4C'],
                ],
                'description' => ['en' => 'The flagship BMW sedan offering the pinnacle of luxury and innovation.', 'ar' => 'سيارة بي إم دبليو الرائدة التي تقدم قمة الفخامة والابتكار.'],
                'features' => ['en' => 'Executive Lounge Seating, Theater Screen, Bowers & Wilkins Sound', 'ar' => 'مقاعد تنفيذية فاخرة، شاشة ترفيه، نظام باورز آند ويلكنز'],
                'is_featured' => true,
                'is_active' => true,
                'is_highlighted' => 'featured',
                'availability_status' => 'available',
            ],
            [
                'brand_id' => $bmw->id,
                'name' => ['en' => 'BMW X3', 'ar' => 'بي إم دبليو X3'],
                'slug' => ['en' => 'bmw-x3', 'ar' => 'بي-إم-دبليو-x3'],
                'model' => 'X3 xDrive30i',
                'year' => 2025,
                'type' => 'suv',
                'cash_price' => 195000,
                'min_down_payment' => 39000,
                'min_installment' => 5200,
                'specs' => [
                    ['label' => 'Engine', 'value' => '2.0L I4 Twin-Turbo'],
                    ['label' => 'Horsepower', 'value' => '248 HP'],
                    ['label' => 'Fuel Type', 'value' => 'Petrol'],
                    ['label' => 'Transmission', 'value' => 'Automatic 8-Speed'],
                    ['label' => 'Seats', 'value' => '5'],
                ],
                'colors' => [
                    ['name' => 'Phytonic Blue', 'hex' => '#2C3E50'],
                    ['name' => 'Black', 'hex' => '#000000'],
                    ['name' => 'White', 'hex' => '#FFFFFF'],
                ],
                'description' => ['en' => 'A compact luxury SUV with agile handling and premium craftsmanship.', 'ar' => 'سيارة دفع رباعي فاخرة مدمجة مع معالجة رشيقة وحرفية ممتازة.'],
                'features' => ['en' => 'Ambient Lighting, Digital Instrument Cluster, Power Tailgate', 'ar' => 'إضاءة محيطة، شاشة عدادات رقمية، باب خلفي كهربائي'],
                'is_featured' => true,
                'is_active' => true,
                'is_highlighted' => 'none',
                'availability_status' => 'available',
            ],
        ];

        foreach ($cars as $data) {

            Car::query()->updateOrCreate(
                ['slug->en' => $data['slug']['en']],
                $data,
            );
        }
    }
}
