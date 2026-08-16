<?php

namespace App\Http\Resources\Store;

use App\Casts\AsImageUrl;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TestimonialCardResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'job_title' => $this->title,
            'avatar' => AsImageUrl::url($this->image),
            'rating' => $this->rating,
            'content' => $this->content,
        ];
    }
}
