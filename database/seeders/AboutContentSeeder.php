<?php

namespace Database\Seeders;

use App\Models\CoreValue;
use App\Models\WhyChooseUsItem;
use Illuminate\Database\Seeder;

class AboutContentSeeder extends Seeder
{
    public function run(): void
    {
        $coreValues = [
            ['icon' => 'heroicon-o-hand-raised', 'title' => ['ar' => 'الاهتمام', 'en' => 'Care']],
            ['icon' => 'heroicon-o-bolt', 'title' => ['ar' => 'السرعة', 'en' => 'Speed']],
            ['icon' => 'heroicon-o-shield-check', 'title' => ['ar' => 'الجودة', 'en' => 'Quality']],
            ['icon' => 'heroicon-o-lock-closed', 'title' => ['ar' => 'ثقة', 'en' => 'Trust']],
        ];

        foreach ($coreValues as $index => $value) {
            CoreValue::updateOrCreate(
                ['title->en' => $value['title']['en']],
                ['icon' => $value['icon'], 'title' => $value['title'], 'sort_order' => $index, 'is_active' => true]
            );
        }

        $whyChooseUs = [
            ['icon' => 'heroicon-o-user-group', 'title' => ['ar' => 'فريق متخصص', 'en' => 'Specialized Team']],
            ['icon' => 'heroicon-o-truck', 'title' => ['ar' => 'توصيل مجاني', 'en' => 'Free Delivery']],
            ['icon' => 'heroicon-o-currency-dollar', 'title' => ['ar' => 'أسعار شفافة', 'en' => 'Transparent Pricing']],
            ['icon' => 'heroicon-o-bolt', 'title' => ['ar' => 'إجراءات سريعة', 'en' => 'Fast Procedures']],
            ['icon' => 'heroicon-o-banknotes', 'title' => ['ar' => 'تمويل ميسر', 'en' => 'Easy Financing']],
            ['icon' => 'heroicon-o-shield-check', 'title' => ['ar' => 'ضمان الجودة', 'en' => 'Quality Guarantee']],
        ];

        foreach ($whyChooseUs as $index => $item) {
            WhyChooseUsItem::updateOrCreate(
                ['title->en' => $item['title']['en']],
                ['icon' => $item['icon'], 'title' => $item['title'], 'sort_order' => $index, 'is_active' => true]
            );
        }
    }
}
