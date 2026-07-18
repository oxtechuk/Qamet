<?php

namespace App\Http\Resources\Store;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OfferCarResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'main_image' => $this->main_image,
            'cash_price' => $this->cash_price,
            'brand' => $this->whenLoaded('brand', fn () => [
                'id' => $this->brand?->id,
                'name' => $this->brand?->name,
            ]),
        ];
    }
}
