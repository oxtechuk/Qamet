<?php

namespace App\Http\Resources\Store;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogPostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'thumbnail' => $this->thumbnail,
            'excerpt' => $this->excerpt,
            'published_at' => $this->published_at,
            'employee' => $this->whenLoaded('employee', fn () => [
                'name' => $this->employee?->name,
                'role' => $this->employee?->role,
                'avatar' => $this->employee?->avatar,
            ]),
            'categories' => $this->whenLoaded('categories', fn () => BlogCategoryResource::collection($this->categories)),
            'reading_time' => $this->reading_time,
        ];
    }
}
