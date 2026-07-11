<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalculatorLead extends Model
{
    protected $fillable = ['name', 'phone', 'car_id', 'details'];

    protected $casts = [
        'details' => 'array'
    ];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
