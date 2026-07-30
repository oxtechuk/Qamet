<?php

namespace App\Http\Resources\Store;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarMiniResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'main_image' => $this->main_image,
            'thumbnail' => $this->thumbnail,
            'cash_price' => $this->cash_price,
            'current_price' => $this->current_price,
            'savings' => max(0, $this->cash_price - $this->current_price),
            'min_installment' => $this->min_installment,
            'min_down_payment' => $this->min_down_payment,
            'type' => $this->type,
            'year' => $this->year,
            'specs' => $this->specs,
            'colors' => $this->colors,
            'is_featured' => $this->is_featured,
            'availability_status' => $this->availability_status,
            'highlight' => $this->whenLoaded('highlight', fn () => [
                'id' => $this->highlight->id,
                'text' => $this->highlight->{'text_'.app()->getLocale()},
                'text_ar' => $this->highlight->text_ar,
                'color' => $this->highlight->color,
            ]),
            'is_current_year' => now()->format('Y') == $this->year,
            'brand' => $this->whenLoaded('brand', fn () => [
                'id' => $this->brand?->id,
                'name' => $this->brand?->name,
            ]),
            'category' => $this->whenLoaded('category', fn () => CarCategoryResource::make($this->category),
            ),
        ];
    }
}
