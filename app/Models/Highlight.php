<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Highlight extends Model
{
    protected $fillable = ['text_ar', 'text_en', 'color'];

    public function cars(): HasMany
    {
        return $this->hasMany(Car::class, 'highlight_id');
    }
}
