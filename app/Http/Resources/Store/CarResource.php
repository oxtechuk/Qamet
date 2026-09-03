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
            'exterior_colors' => $this->formatted_exterior_colors,
            'interior_colors' => $this->formatted_interior_colors,
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
                'name' => is_array($spec->name) ? ($spec->name[app()->getLocale()] ?? $spec->name['ar'] ?? reset($spec->name)) : (string) $spec->name,
                'value' => is_array($spec->value) ? ($spec->value[app()->getLocale()] ?? $spec->value['ar'] ?? reset($spec->value)) : (string) ($spec->value ?? ''),
                'icon' => $spec->icon,
            ])),
            'features_list' => $this->whenLoaded('features_list', fn () => $this->features_list->map(fn ($feat) => [
                'id' => $feat->id,
                'name' => is_array($feat->name) ? ($feat->name[app()->getLocale()] ?? $feat->name['ar'] ?? reset($feat->name)) : (string) $feat->name,
                'value' => is_array($feat->value) ? ($feat->value[app()->getLocale()] ?? $feat->value['ar'] ?? reset($feat->value)) : (string) ($feat->value ?? ''),
                'icon' => $feat->icon,
            ])),
            'safety_features' => $this->whenLoaded('safety_features', fn () => $this->safety_features->map(fn ($safetyFeat) => [
                'id' => $safetyFeat->id,
                'name' => is_array($safetyFeat->name) ? ($safetyFeat->name[app()->getLocale()] ?? $safetyFeat->name['ar'] ?? reset($safetyFeat->name)) : (string) $safetyFeat->name,
                'value' => is_array($safetyFeat->value) ? ($safetyFeat->value[app()->getLocale()] ?? $safetyFeat->value['ar'] ?? reset($safetyFeat->value)) : (string) ($safetyFeat->value ?? ''),
                'icon' => $safetyFeat->icon,
            ])),
            'related_cars' => $this->whenLoaded('relatedCars', fn () => CarMiniResource::collection($this->relatedCars),
            ),
            'variants' => $this->whenLoaded('variants', fn () => $this->variants->map(fn ($variant) => [
                'id' => $variant->id,
                'name' => $variant->name,
                'image' => $variant->image_url,
                'cash_price' => $variant->cash_price,
                'min_installment' => $variant->min_installment,
                'min_down_payment' => $variant->min_down_payment,
                'specs' => $variant->specs,
            ])),
        ];
    }
}
