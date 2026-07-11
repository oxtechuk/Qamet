<?php

namespace App\Http\Controllers\Api\Store;

use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Resources\Store\CarTypeResource;
use App\Models\CarType;

final class CarTypeController extends ApiBaseController
{
    public function index()
    {
        $types = CarType::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return $this->respondSuccess(
            CarTypeResource::collection($types)->resolve(),
            'Car types retrieved successfully'
        );
    }
}
