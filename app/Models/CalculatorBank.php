<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalculatorBank extends Model
{
    protected $fillable = [
        'name',
        'annual_rate',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'annual_rate' => 'float',
            'is_active' => 'boolean',
        ];
    }

    public function scopeActiveOrdered($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order')->orderBy('id');
    }
}
