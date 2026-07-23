<?php

namespace App\Models;

use App\Casts\AsImageUrl;
use App\Traits\HasBilingualFields;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Brand extends Model
{
    use HasBilingualFields, HasTranslations;

    public $translatable = ['name'];

    protected $fillable = ['name', 'slug', 'logo', 'is_active', 'brand_type_id'];

    protected $casts = [
        'is_active' => 'boolean',
        'logo' => AsImageUrl::class,
    ];

    public function cars(): HasMany
    {
        return $this->hasMany(Car::class);
    }

    public function brandType(): BelongsTo
    {
        return $this->belongsTo(BrandType::class);
    }
}
