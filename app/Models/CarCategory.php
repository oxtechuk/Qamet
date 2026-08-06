<?php

namespace App\Models;

use App\Traits\HasBilingualFields;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class CarCategory extends Model
{
    use HasBilingualFields, HasTranslations;

    public $translatable = ['name'];

    protected $fillable = ['name', 'name_ar', 'name_en', 'slug', 'sort_order', 'is_active'];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (self $model) {
            if (empty($model->slug)) {
                $name = $model->name_en ?: ($model->name_ar ?: 'category');
                $model->slug = \Illuminate\Support\Str::slug($name) ?: ('cat-'.uniqid());
            }
        });
    }

    public function cars(): HasMany
    {
        return $this->hasMany(Car::class, 'category_id');
    }

    public function scopeActiveOrdered($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order')->orderBy('id');
    }
}
