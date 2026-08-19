<?php

namespace App\Http\Resources\Store;

use App\Casts\AsImageUrl;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'main_image' => $this->main_image,
            'thumbnail' => AsImageUrl::url($this->thumbnail),
            'images' => $this->whenLoaded('images', fn () => $this->images->map(fn ($img) => AsImageUrl::url($img->image_path))->values()),
            'exterior_images' => $this->whenLoaded('images', fn () => $this->images->where('type', 'exterior')->map(fn ($img) => AsImageUrl::url($img->image_path))->values()),
            'interior_images' => $this->whenLoaded('images', fn () => $this->images->where('type', 'interior')->map(fn ($img) => AsImageUrl::url($img->image_path))->values()),
            'cash_price' => $this->cash_price,
            'current_price' => $this->current_price,
            'savings' => max(0, $this->cash_price - $this->current_price),
            'min_installment' => $this->min_installment,
            'min_down_payment' => $this->min_down_payment,
            'year' => $this->year,
            'is_current_year' => now()->format('Y') == $this->year,
            'type' => $this->type,
            'colors' => $this->formatted_colors,
            'specs' => $this->specs,
            'description' => $this->description,
            'features' => $this->features,
            'is_featured' => $this->is_featured,
            'availability_status' => $this->availability_status,
            'highlight' => $this->whenLoaded('highlight', fn () => [
                'id' => $this->highlight->id,
                'text' => $this->highlight->text_en,
                'text_ar' => $this->highlight->text_ar,
                'color' => $this->highlight->color,
            ]),
            'views' => $this->whenHas('views'),
            'brand' => $this->whenLoaded('brand', fn () => BrandResource::make($this->brand),
            ),
            'category' => $this->whenLoaded('category', fn () => CarCategoryResource::make($this->category),
            ),
            'active_offer' => $this->whenLoaded('activeOffers', fn () => $this->activeOffer ? OfferResource::make($this->activeOffer) : null,
            ),
            'active_offers' => $this->whenLoaded('activeOffers', fn () => OfferResource::collection($this->activeOffers),
            ),
            'offers' => $this->whenLoaded('offers', fn () => OfferResource::collection($this->offers),
            ),
            'specifications' => $this->whenLoaded('specifications', fn () => $this->specifications->map(fn ($spec) => [
                'id' => $spec->id,
                'name' => $spec->name,
                'value' => $spec->value,
                'icon' => $spec->icon,
            ]),
            ),
            'features_list' => $this->whenLoaded('features_list', fn () => $this->features_list->map(fn ($feat) => [
                'id' => $feat->id,
                'name' => $feat->name,
                'value' => $feat->value,
                'icon' => $feat->icon,
            ]),
            ),
            'safety_features' => $this->whenLoaded('safety_features', fn () => $this->safety_features->map(fn ($safetyFeat) => [
                'id' => $safetyFeat->id,
                'name' => $safetyFeat->name,
                'value' => $safetyFeat->value,
                'icon' => $safetyFeat->icon,
            ]),
            ),
            'related_cars' => $this->whenLoaded('relatedCars', fn () => CarMiniResource::collection($this->relatedCars),
            ),
        ];
    }
}
