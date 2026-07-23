<?php

namespace App\Http\Resources\Store;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BranchResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'city' => $this->city,
            'name' => $this->name,
            'address' => $this->address,
            'map_link' => $this->map_link,
            'departments' => $this->localizedDepartments(),
            'sort_order' => $this->sort_order,
        ];
    }
}
