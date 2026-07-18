<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalculatorFactor extends Model
{
    public const TYPE_GENDER = 'gender';

    public const TYPE_AGE_BAND = 'age_band';

    public const TYPE_SALARY_BAND = 'salary_band';

    public const TYPE_EMPLOYMENT = 'employment';

    protected $fillable = [
        'type',
        'code',
        'label_ar',
        'label_en',
        'min_age',
        'max_age',
        'rate_adjustment',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'rate_adjustment' => 'float',
            'is_active' => 'boolean',
        ];
    }

    public function scopeActiveOrdered($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order')->orderBy('id');
    }

    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function labelForLocale(?string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();
        if ($locale === 'en' && $this->label_en) {
            return $this->label_en;
        }

        return $this->label_ar;
    }

    public static function findAgeBandForAge(int $age): ?self
    {
        return self::query()
            ->ofType(self::TYPE_AGE_BAND)
            ->activeOrdered()
            ->whereNotNull('min_age')
            ->whereNotNull('max_age')
            ->where('min_age', '<=', $age)
            ->where('max_age', '>=', $age)
            ->first();
    }
}
