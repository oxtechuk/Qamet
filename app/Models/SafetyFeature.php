<?php

namespace App\Models;

use App\Traits\HasBilingualFields;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;

class SafetyFeature extends Model
{
    use HasBilingualFields, HasTranslations;

    public $translatable = ['name', 'value'];

    protected $fillable = ['name', 'name_ar', 'name_en', 'value', 'icon'];

    public function cars(): BelongsToMany
    {
        return $this->belongsToMany(Car::class, 'car_safety_feature');
    }
}
