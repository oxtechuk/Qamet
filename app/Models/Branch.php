<?php

namespace App\Models;

use App\Traits\HasBilingualFields;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Branch extends Model
{
    use HasBilingualFields, HasTranslations;

    protected $fillable = ['city', 'name', 'address', 'map_link', 'departments', 'sort_order', 'is_active'];

    public $translatable = ['city', 'name', 'address'];

    protected function casts(): array
    {
        return [
            'departments' => 'array',
            'is_active' => 'boolean',
        ];
    }

    public function localizedDepartments(): array
    {
        $locale = app()->getLocale();

        return array_map(fn (array $department): array => [
            'label' => $department["label_{$locale}"] ?? $department['label_en'] ?? $department['label_ar'] ?? '',
            'phone' => $department['phone'] ?? '',
            'hours' => $department["hours_{$locale}"] ?? $department['hours_en'] ?? $department['hours_ar'] ?? '',
        ], $this->departments ?? []);
    }
}
