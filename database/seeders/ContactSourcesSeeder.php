<?php

namespace Database\Seeders;

use App\Models\ContactSource;
use Illuminate\Database\Seeder;

class ContactSourcesSeeder extends Seeder
{
    public function run(): void
    {
        if (ContactSource::query()->exists()) {
            return;
        }

        $rows = [
            ['name' => 'الموقع الإلكتروني', 'sort_order' => 1],
            ['name' => 'واتساب', 'sort_order' => 2],
            ['name' => 'إنستغرام', 'sort_order' => 3],
            ['name' => 'تويتر / X', 'sort_order' => 4],
            ['name' => 'إعلان مدفوع', 'sort_order' => 5],
            ['name' => 'إحالة / معارف', 'sort_order' => 6],
            ['name' => 'زيارة المعرض', 'sort_order' => 7],
            ['name' => 'أخرى', 'sort_order' => 99],
        ];

        foreach ($rows as $r) {
            ContactSource::create($r);
        }
    }
}
