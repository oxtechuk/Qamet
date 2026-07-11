<?php

declare(strict_types=1);

namespace App\Http\Api\Response\Builder;

use App\Http\Api\Contracts\ApiResponse;

final class ErrorResponseBuilder
{
    public function __construct(
        private readonly ApiResponseBuilder $builder,
    ) {}

    public function notFound(string $message = 'Resource not found'): ApiResponse
    {
        return $this->builder
            ->success(false)
            ->message($message)
            ->status(404)
            ->build();
    }

    public function validationError(?array $errors = null, string $message = 'Validation failed'): ApiResponse
    {
        return $this->builder
            ->success(false)
            ->message($message)
            ->errors($errors)
            ->status(422)
            ->build();
    }

    public function unauthorized(string $message = 'Unauthorized'): ApiResponse
    {
        return $this->builder
            ->success(false)
            ->message($message)
            ->status(401)
            ->build();
    }

    public function forbidden(string $message = 'Forbidden'): ApiResponse
    {
        return $this->builder
            ->success(false)
            ->message($message)
            ->status(403)
            ->build();
    }

    public function serverError(string $message = 'Internal server error'): ApiResponse
    {
        return $this->builder
            ->success(false)
            ->message($message)
            ->status(500)
            ->build();
    }
}
