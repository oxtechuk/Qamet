<?php

namespace App\Models;

use App\Casts\AsImageUrl;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ProjectDesign extends Model
{
    use HasTranslations;

    protected $fillable = ['type', 'name', 'image', 'link', 'price', 'top_speed', 'power', 'year', 'badge_text', 'is_featured', 'sort_order', 'color'];

    public $translatable = ['name'];

    protected $casts = [
        'is_featured' => 'boolean',
        'image' => AsImageUrl::class,
    ];
}
