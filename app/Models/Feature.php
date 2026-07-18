<?php

namespace App\Models;

use App\Traits\HasBilingualFields;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;

class Feature extends Model
{
    use HasBilingualFields, HasTranslations;

    public $translatable = ['name'];

    protected $fillable = ['name', 'icon'];

    public function cars(): BelongsToMany
    {
        return $this->belongsToMany(Car::class, 'car_feature');
    }
}
