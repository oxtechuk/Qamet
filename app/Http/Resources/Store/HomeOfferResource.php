<?php

namespace App\Http\Resources\Store;

use App\Casts\AsImageUrl;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HomeOfferResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'image' => AsImageUrl::url($this->image),
            'installment_starts_from' => $this->special_installment ?? $this->car->min_installment ?? null,
            'time_remaining' => $this->time_remaining,
            'is_expired' => $this->is_expired,
            'car' => $this->whenLoaded('car', fn () => CarMiniResource::make($this->car)->resolve()),
        ];
    }
}
