<?php

namespace Database\Seeders;

use App\Models\CalculatorBank;
use App\Models\CalculatorFactor;
use Illuminate\Database\Seeder;

class CalculatorDefaultsSeeder extends Seeder
{
    public function run(): void
    {
        if (CalculatorBank::query()->exists()) {
            return;
        }

        $banks = [
            ['name' => 'البنك الأهلي', 'annual_rate' => 3.5, 'sort_order' => 1],
            ['name' => 'البنك الراجحي', 'annual_rate' => 3.8, 'sort_order' => 2],
            //   ['name' => 'البنك الأول', 'annual_rate' => 4.0, 'sort_order' => 3],
            ['name' => 'بنك الرياض', 'annual_rate' => 4.5, 'sort_order' => 4],
        ];
        foreach ($banks as $b) {
            CalculatorBank::create($b);
        }

        $factors = [
            ['type' => CalculatorFactor::TYPE_GENDER, 'code' => 'male', 'label_ar' => 'ذكر', 'label_en' => 'Male', 'rate_adjustment' => 0, 'sort_order' => 1],
            ['type' => CalculatorFactor::TYPE_GENDER, 'code' => 'female', 'label_ar' => 'أنثى', 'label_en' => 'Female', 'rate_adjustment' => 0, 'sort_order' => 2],

            ['type' => CalculatorFactor::TYPE_AGE_BAND, 'code' => 'age_15_24', 'label_ar' => '15 – 24 سنة', 'label_en' => '15 – 24 years', 'min_age' => 15, 'max_age' => 24, 'rate_adjustment' => 0, 'sort_order' => 1],
            ['type' => CalculatorFactor::TYPE_AGE_BAND, 'code' => 'age_25_34', 'label_ar' => '25 – 34 سنة', 'label_en' => '25 – 34 years', 'min_age' => 25, 'max_age' => 34, 'rate_adjustment' => 0, 'sort_order' => 2],
            ['type' => CalculatorFactor::TYPE_AGE_BAND, 'code' => 'age_35_plus', 'label_ar' => '35 سنة فأكثر', 'label_en' => '35+ years', 'min_age' => 35, 'max_age' => 100, 'rate_adjustment' => 0, 'sort_order' => 3],

            ['type' => CalculatorFactor::TYPE_SALARY_BAND, 'code' => 'below_20k', 'label_ar' => 'أقل من 20 ألف', 'label_en' => 'Below 20,000 SAR', 'rate_adjustment' => 0, 'sort_order' => 1],
            ['type' => CalculatorFactor::TYPE_SALARY_BAND, 'code' => '20k_35k', 'label_ar' => '20 ألف – 35 ألف', 'label_en' => '20,000 – 35,000 SAR', 'rate_adjustment' => 0, 'sort_order' => 2],
            ['type' => CalculatorFactor::TYPE_SALARY_BAND, 'code' => 'above_35k', 'label_ar' => 'أكثر من 35 ألف', 'label_en' => 'Above 35,000 SAR', 'rate_adjustment' => 0, 'sort_order' => 3],

            ['type' => CalculatorFactor::TYPE_EMPLOYMENT, 'code' => 'private', 'label_ar' => 'قطاع خاص', 'label_en' => 'Private sector', 'rate_adjustment' => 0, 'sort_order' => 1],
            ['type' => CalculatorFactor::TYPE_EMPLOYMENT, 'code' => 'government', 'label_ar' => 'قطاع حكومي', 'label_en' => 'Government', 'rate_adjustment' => 0, 'sort_order' => 2],
        ];

        foreach ($factors as $f) {
            CalculatorFactor::create($f);
        }
    }
}
