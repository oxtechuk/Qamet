<?php

namespace App\Models;

use App\Traits\HasBilingualFields;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class GalleryItem extends Model
{
    /** @use HasFactory<\Database\Factories\GalleryItemFactory> */
    use HasBilingualFields, HasFactory, HasTranslations;

    protected $fillable = ['type', 'file', 'thumbnail', 'caption', 'alt_text', 'sort_order', 'is_active'];

    public $translatable = ['caption'];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }
}
