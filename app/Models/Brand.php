<?php

namespace App\Models;


use App\Traits\HasBilingualFields;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Brand extends Model
{
    use HasBilingualFields, HasTranslations;

    public $translatable = ['name'];

    protected $fillable = ['name', 'name_ar', 'name_en', 'slug', 'logo', 'is_active', 'brand_type_id'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $model) {
            if (empty($model->slug)) {
                $name = $model->name_en ?: ($model->name_ar ?: 'brand');
                $model->slug = \Illuminate\Support\Str::slug($name) ?: ('brand-'.uniqid());
            }
        });
    }

    public function cars(): HasMany
    {
        return $this->hasMany(Car::class);
    }

    public function brandType(): BelongsTo
    {
        return $this->belongsTo(BrandType::class);
    }
}
