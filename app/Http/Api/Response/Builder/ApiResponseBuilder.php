<?php

declare(strict_types=1);

namespace App\Http\Api\Response\Builder;

use App\Http\Api\Contracts\ApiResponse;
use Illuminate\Pagination\LengthAwarePaginator;

final class ApiResponseBuilder
{
    private bool $success = true;

    private string $message = '';

    private mixed $data = null;

    private ?array $errors = null;

    private ?array $meta = null;

    private int $status = 200;

    public function success(bool $success): self
    {
        $this->success = $success;

        return $this;
    }

    public function message(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function data(mixed $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function errors(?array $errors): self
    {
        $this->errors = $errors;

        return $this;
    }

    public function meta(?array $meta): self
    {
        $this->meta = $meta;

        return $this;
    }

    public function status(int $statusCode): self
    {
        $this->status = $statusCode;

        return $this;
    }

    public function paginated(LengthAwarePaginator $paginator, string $message = 'Resources retrieved successfully'): ApiResponse
    {
        return $this
            ->success(true)
            ->message($message)
            ->data($paginator->items())
            ->meta([
                'current_page' => $paginator->currentPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
                'last_page' => $paginator->lastPage(),
                'from' => $paginator->firstItem(),
                'to' => $paginator->lastItem(),
            ])
            ->build();
    }

    public function build(): ApiResponse
    {
        return new ApiResponse(
            success: $this->success,
            message: $this->message,
            data: $this->data,
            errors: $this->errors,
            meta: $this->meta,
            status: $this->status,
        );
    }
}
