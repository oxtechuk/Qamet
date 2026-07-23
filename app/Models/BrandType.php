<?php

namespace App\Models;

use App\Traits\HasBilingualFields;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class BrandType extends Model
{
    use HasBilingualFields, HasTranslations;

    public $translatable = ['name'];

    protected $fillable = ['name', 'slug', 'sort_order', 'is_active'];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function brands(): HasMany
    {
        return $this->hasMany(Brand::class);
    }
}
