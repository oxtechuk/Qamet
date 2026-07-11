<?php

namespace App\Http\Controllers\Api;

use App\Http\Api\Contracts\ApiResponse;
use App\Http\Requests\Api\ExampleRequest;

final class ExampleController extends ApiBaseController
{
    public function index(): ApiResponse
    {
        return $this->respondSuccess(['ping' => 'pong'], 'API is working');
    }

    public function store(ExampleRequest $request): ApiResponse
    {
        return $this->respondCreated(
            data: $request->validated(),
            message: 'Example validated successfully'
        );
    }
}
