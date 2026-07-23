<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class HomeContentSeeder extends Seeder
{
    public function run(): void
    {
        Setting::updateOrCreate(
            ['key' => 'home_budget_brackets'],
            ['value' => [
                ['label_ar' => 'أقل من 150 ألف', 'label_en' => 'Under 150k', 'min' => 0, 'max' => 150000],
                ['label_ar' => '150 - 250 ألف', 'label_en' => '150k - 250k', 'min' => 150001, 'max' => 250000],
                ['label_ar' => '250 - 350 ألف', 'label_en' => '250k - 350k', 'min' => 250001, 'max' => 350000],
                ['label_ar' => 'أكثر من 350 ألف', 'label_en' => 'Over 350k', 'min' => 350001, 'max' => null],
            ]]
        );
    }
}
