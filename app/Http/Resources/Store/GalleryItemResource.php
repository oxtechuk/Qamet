<?php

namespace App\Http\Resources\Store;

use App\Casts\AsImageUrl;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GalleryItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'type' => $this->type,
            'file' => AsImageUrl::url($this->file),
            'thumbnail' => AsImageUrl::url($this->thumbnail),
            'caption' => $this->caption,
            'alt_text' => $this->alt_text,
        ];
    }
}
