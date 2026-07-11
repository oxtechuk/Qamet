<?php

namespace Database\Seeders;

use App\Models\CarType;
use Illuminate\Database\Seeder;

class CarTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['slug' => 'sedan', 'name' => ['ar' => 'سيدان', 'en' => 'Sedan'], 'sort_order' => 1],
            ['slug' => 'suv', 'name' => ['ar' => 'SUV', 'en' => 'SUV'], 'sort_order' => 2],
            ['slug' => 'coupe', 'name' => ['ar' => 'كوبيه', 'en' => 'Coupe'], 'sort_order' => 3],
            ['slug' => 'hatchback', 'name' => ['ar' => 'هاتشباك', 'en' => 'Hatchback'], 'sort_order' => 4],
            ['slug' => 'pickup', 'name' => ['ar' => 'بيك آب', 'en' => 'Pickup'], 'sort_order' => 5],
            ['slug' => 'van', 'name' => ['ar' => 'فان', 'en' => 'Van'], 'sort_order' => 6],
            ['slug' => 'other', 'name' => ['ar' => 'أخرى', 'en' => 'Other'], 'sort_order' => 7],
        ];

        foreach ($types as $type) {
            CarType::create($type);
        }
    }
}
