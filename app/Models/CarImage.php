<?php

namespace App\Models;

use App\Casts\AsImageUrl;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CarImage extends Model
{
    protected $fillable = ['car_id', 'image_path', 'type', 'alt', 'sort_order'];

    protected $casts = [
        'image_path' => AsImageUrl::class,
    ];

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }
}
