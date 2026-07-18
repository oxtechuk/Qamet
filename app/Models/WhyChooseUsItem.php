<?php

namespace App\Models;

use App\Traits\HasBilingualFields;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class WhyChooseUsItem extends Model
{
    /** @use HasFactory<\Database\Factories\WhyChooseUsItemFactory> */
    use HasBilingualFields, HasFactory, HasTranslations;

    protected $fillable = ['icon', 'title', 'description', 'sort_order', 'is_active'];

    public $translatable = ['title', 'description'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }
}
