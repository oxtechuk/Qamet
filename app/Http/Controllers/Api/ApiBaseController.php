<?php

namespace App\Http\Controllers\Api;

use App\Http\Api\Contracts\ApiResponse;
use App\Http\Api\Response\Builder\ApiResponseBuilder;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class ApiBaseController extends Controller
{
    public function __construct(
        protected readonly ApiResponseBuilder $responseBuilder,
    ) {}

    protected function respond(mixed $data = null, string $message = 'Operation completed successfully', int $status = 200): ApiResponse
    {
        return $this->responseBuilder
            ->success($status < 400)
            ->message($message)
            ->data($data)
            ->status($status)
            ->build();
    }

    protected function respondSuccess(mixed $data = null, string $message = 'Operation completed successfully'): ApiResponse
    {
        return $this->respond($data, $message, 200);
    }

    protected function respondCreated(mixed $data = null, string $message = 'Resource created successfully'): ApiResponse
    {
        return $this->respond($data, $message, 201);
    }

    protected function respondError(string $message = 'An error occurred', int $status = 400): ApiResponse
    {
        return $this->responseBuilder
            ->success(false)
            ->message($message)
            ->status($status)
            ->build();
    }

    protected function respondPaginated(LengthAwarePaginator $paginator, string $message = 'Resources retrieved successfully'): ApiResponse
    {
        return $this->responseBuilder->paginated($paginator, $message);
    }

    protected function respondDeleted(string $message = 'Resource deleted successfully'): ApiResponse
    {
        return $this->respondSuccess(null, $message);
    }
}
