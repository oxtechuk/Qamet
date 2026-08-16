<?php

namespace App\Http\Resources\Store;

use App\Casts\AsImageUrl;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogPostDetailResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'thumbnail' => AsImageUrl::url($this->thumbnail),
            'content' => $this->content,
            'excerpt' => $this->excerpt,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'published_at' => $this->published_at,
            'employee' => $this->whenLoaded('employee', fn () => [
                'name' => $this->employee?->name,
                'role' => $this->employee?->role,
                'avatar' => AsImageUrl::url($this->employee?->avatar),
            ]),
            'categories' => $this->whenLoaded('categories', fn () => BlogCategoryResource::collection($this->categories)),
            'reading_time' => $this->reading_time,
            'meta_keywords' => $this->meta_keywords,
            'is_featured' => $this->is_featured,
            'related_posts' => $this->whenLoaded('relatedPosts', fn () => BlogPostResource::collection($this->relatedPosts),
            ),
        ];
    }
}
