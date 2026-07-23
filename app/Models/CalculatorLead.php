<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CalculatorLead extends Model
{
    protected $fillable = [
        'name', 'phone', 'email', 'city', 'salary', 'monthly_obligations',
        'preferred_bank_id', 'car_ids', 'car_price', 'notes', 'details',
    ];

    protected $casts = [
        'car_ids' => 'array',
        'details' => 'array',
        'salary' => 'decimal:2',
        'monthly_obligations' => 'decimal:2',
        'car_price' => 'decimal:2',
    ];

    public function preferredBank(): BelongsTo
    {
        return $this->belongsTo(CalculatorBank::class, 'preferred_bank_id');
    }
}
