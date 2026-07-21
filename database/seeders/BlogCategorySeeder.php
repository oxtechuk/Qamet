<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use Illuminate\Database\Seeder;

class BlogCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => ['en' => 'Car Reviews', 'ar' => 'مراجعات السيارات'],
                'slug' => 'car-reviews',
                'icon' => 'bi-star',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => ['en' => 'Buying Guides', 'ar' => 'أدلة الشراء'],
                'slug' => 'buying-guides',
                'icon' => 'bi-cart',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => ['en' => 'Industry News', 'ar' => 'أخبار الصناعة'],
                'slug' => 'industry-news',
                'icon' => 'bi-newspaper',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => ['en' => 'Maintenance Tips', 'ar' => 'نصائح الصيانة'],
                'slug' => 'maintenance-tips',
                'icon' => 'bi-tools',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'name' => ['en' => 'Technology', 'ar' => 'التكنولوجيا'],
                'slug' => 'technology',
                'icon' => 'bi-cpu',
                'sort_order' => 5,
                'is_active' => true,
            ],
        ];

        foreach ($categories as $data) {
            BlogCategory::query()->updateOrCreate(
                ['slug' => $data['slug']],
                $data,
            );
        }
    }
}
