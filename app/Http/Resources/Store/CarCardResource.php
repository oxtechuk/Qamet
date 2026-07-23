<?php

namespace App\Http\Resources\Store;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarCardResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'main_image' => $this->main_image,
            'cash_price' => $this->cash_price,
            'current_price' => $this->current_price,
            'savings' => max(0, $this->cash_price - $this->current_price),
            'min_installment' => $this->min_installment,
            'year' => $this->year,
            'highlight' => $this->whenLoaded('highlight', fn () => [
                'id' => $this->highlight->id,
                'text' => $this->highlight->text_en,
                'text_ar' => $this->highlight->text_ar,
                'color' => $this->highlight->color,
            ]),
            'brand' => $this->whenLoaded('brand', fn () => [
                'id' => $this->brand?->id,
                'name' => $this->brand?->name,
            ]),
        ];
    }
}
