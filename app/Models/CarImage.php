<?php

namespace App\Models;

use App\Casts\AsImageUrl;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CarImage extends Model
{
    protected $fillable = ['car_id', 'image_path', 'type', 'alt', 'sort_order'];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute(): ?string
    {
        return AsImageUrl::url($this->image_path);
    }

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }
}
