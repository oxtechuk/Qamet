<?php

namespace App\Models;

use App\Casts\AsImageUrl;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CarVariant extends Model
{
    protected $fillable = [
        'car_id',
        'name',
        'image',
        'cash_price',
        'min_installment',
        'min_down_payment',
        'specs',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'specs' => 'array',
            'cash_price' => 'decimal:2',
            'min_installment' => 'decimal:2',
            'min_down_payment' => 'decimal:2',
        ];
    }

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    public function getImageUrlAttribute(): ?string
    {
        return AsImageUrl::url($this->image);
    }
}
