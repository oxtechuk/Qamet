<?php

namespace App\Http\Resources\Store;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TestimonialResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'title' => $this->title,
            'content' => $this->content,
            'image' => $this->image,
            'review_image' => $this->review_image,
            'rating' => $this->rating,
        ];
    }
}
