<?php

namespace App\Models;

use App\Casts\AsImageUrl;
use App\Traits\HasBilingualFields;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Testimonial extends Model
{
    use HasBilingualFields, HasTranslations;

    protected $fillable = ['name', 'title', 'content', 'image', 'review_image', 'rating', 'is_visible'];

    public $translatable = ['name', 'title', 'content'];

    protected $casts = [
        'is_visible' => 'boolean',
        'image' => AsImageUrl::class,
        'review_image' => AsImageUrl::class,
    ];
}
