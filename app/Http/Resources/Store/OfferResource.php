<?php

namespace App\Http\Resources\Store;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OfferResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'image' => $this->image,
            'discount_percent' => $this->discount_percent,
            'special_price' => $this->special_price,
            'special_installment' => $this->special_installment,
            'starts_at' => $this->starts_at,
            'ends_at' => $this->ends_at,
            'is_active' => $this->is_active,
            'time_remaining' => $this->time_remaining,
            'is_expired' => $this->is_expired,
            'car' => $this->whenLoaded('car', fn () => CarMiniResource::make($this->car)->resolve()),
        ];
    }
}
