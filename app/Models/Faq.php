<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Faq extends Model
{
    use HasTranslations;

    protected $fillable = ['question', 'answer', 'is_visible', 'sort_order'];

    public $translatable = ['question', 'answer'];

    protected function casts(): array
    {
        return [
            'is_visible' => 'boolean',
        ];
    }
}
